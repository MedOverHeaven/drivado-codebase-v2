<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
  public function search(Request $request)
{
    $query = Vehicle::with(['agency', 'photos'])->where('is_available', true);
    
    // Location filter
    if ($request->filled('location')) {
        $query->whereHas('agency', function($q) use ($request) {
            $q->where('city', 'like', '%' . $request->location . '%');
        });
    }

    // Make (Brand) filter
    if ($request->filled('make')) {
        $query->where('make', 'like', '%' . $request->make . '%');
    }

    // Model filter
    if ($request->filled('model')) {
        $query->where('model', 'like', '%' . $request->model . '%');
    }

    // Fuel type filter
    if ($request->filled('fuel')) {
        $fuels = $request->input('fuel');
        $query->whereIn('fuel_type', $fuels);
    }

    // Seats filter
    if ($request->filled('seats')) {
        $seats = $request->input('seats');
        $query->whereIn('seats', $seats);
    }

    // Transmission filter
    if ($request->filled('transmission')) {
        $transmissions = $request->input('transmission');
        $query->whereIn('transmission', $transmissions);
    }

    // Category filter
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Year range filter
    if ($request->filled('year_min')) {
        $query->where('year', '>=', $request->year_min);
    }
    if ($request->filled('year_max')) {
        $query->where('year', '<=', $request->year_max);
    }

    // Price per week filter (falls back to price_per_day * 7)
    if ($request->filled('price_week_min') || $request->filled('price_week_max')) {
        $query->where(function($q) use ($request) {
            if ($request->filled('price_week_min')) {
                $minPrice = $request->price_week_min;
                $q->where(function($subQ) use ($minPrice) {
                    $subQ->where('price_per_week', '>=', $minPrice)
                        ->orWhereRaw('(price_per_day * 7) >= ?', [$minPrice]);
                });
            }
        });

        if ($request->filled('price_week_max')) {
            $maxPrice = $request->price_week_max;
            $query->where(function($q) use ($maxPrice) {
                $q->whereRaw('COALESCE(price_per_week, price_per_day * 7) <= ?', [$maxPrice]);
            });
        }
    }

    // Rating filter
    if ($request->filled('rating')) {
        $ratings = array_map('intval', $request->input('rating'));
        $minRating = min($ratings);
        
        $query->whereHas('bookings.reviews', function($q) use ($minRating) {
            // This will be calculated in the query
        })->with(['bookings.reviews']);
    }

    // Available only toggle
    if ($request->filled('available_only')) {
        $query->where('is_available', true);
    }

    // Sorting
    if ($request->sort == 'price_asc') {
        $query->orderBy('price_per_day', 'asc');
    } elseif ($request->sort == 'price_desc') {
        $query->orderBy('price_per_day', 'desc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $vehicles = $query->paginate(9);

    // Apply rating filter in PHP after pagination to get average reviews per vehicle
    if ($request->filled('rating')) {
        $ratings = array_map('intval', $request->input('rating'));
        $minRating = min($ratings);

        $vehicles->getCollection()->transform(function($vehicle) use ($minRating) {
            // Calculate average rating from reviews
            $avgRating = $vehicle->reviews()->avg('rating') ?? 0;

            $vehicle->avgRating = $avgRating;
            return $vehicle;
        });

        // Filter by rating
        $vehicles->getCollection()->filter(function($vehicle) use ($minRating) {
            return ($vehicle->avgRating ?? 0) >= $minRating;
        });
    }

    return view('search', compact('vehicles'));
}

    public function show($id)
    {
        $vehicle = Vehicle::with(['agency', 'photos'])->findOrFail($id);
        return view('detail', compact('vehicle'));
    }

    public function compare(Request $request)
    {
        $ids = $request->query('ids', []);
        
        // Validate we have 2-3 vehicles to compare
        if (empty($ids) || count($ids) < 2 || count($ids) > 3) {
            return redirect('/search');
        }

        // Load vehicles with their relationships
        $vehicles = Vehicle::with(['agency', 'photos', 'bookings.reviews'])
            ->whereIn('id', $ids)
            ->get();

        if ($vehicles->count() < 2) {
            return redirect('/search');
        }

        // Calculate Drivado Score for each vehicle
        $vehicles = $vehicles->map(function($vehicle) use ($vehicles) {
            $scores = $this->calculateDrivadoScore($vehicle, $vehicles);
            $vehicle->drivado_score = $scores['total'];
            $vehicle->score_breakdown = $scores;
            return $vehicle;
        });

        // Sort by score descending
        $vehicles = $vehicles->sortByDesc('drivado_score')->values();

        return view('compare', compact('vehicles'));
    }

    private function calculateDrivadoScore(Vehicle $vehicle, $allVehicles)
    {
        $scores = [
            'price' => 0,
            'rating' => 0,
            'features' => 0,
            'cancellation' => 0,
            'availability' => 0,
            'total' => 0
        ];

        // 1. Price value (30 pts): cheaper relative to category average = more points
        $categoryVehicles = $allVehicles->where('category', $vehicle->category);
        if ($categoryVehicles->count() > 0) {
            $avgPrice = $categoryVehicles->avg('price_per_day');
            $priceFactor = 1 - ($vehicle->price_per_day / $avgPrice);
            $scores['price'] = max(0, min(30, 30 * (0.5 + $priceFactor)));
        }

        // 2. Rating (25 pts): average review score
        $avgRating = $vehicle->reviews()->avg('rating') ?? 0;
        $scores['rating'] = ($avgRating / 5) * 25;

        // 3. Features/options count (20 pts): with weighted scoring
        $scores['features'] = $this->calculateFeatureScore($vehicle);

        // 4. Cancellation flexibility (15 pts)
        $scores['cancellation'] = $this->calculateCancellationScore($vehicle->cancellation_policy);

        // 5. Availability reliability (10 pts)
        $scores['availability'] = $this->calculateAvailabilityScore($vehicle);

        $scores['total'] = round(array_sum([$scores['price'], $scores['rating'], $scores['features'], $scores['cancellation'], $scores['availability']]), 2);

        return $scores;
    }

    private function calculateFeatureScore($vehicle)
    {
        $features = $vehicle->options ?? [];
        $featureWeights = [
            'gps' => 5,
            'automatique' => 4,
            'automatic' => 4,
            'auto' => 4,
            'ac' => 3,
            'climatisation' => 3,
            'bluetooth' => 3,
            'sunroof' => 3,
            'toit ouvrant' => 3,
            'touchscreen' => 2,
            'écran' => 2,
        ];

        $score = 0;
        $maxScore = 20;

        foreach ($features as $feature) {
            $featureLower = strtolower($feature);
            $matched = false;

            foreach ($featureWeights as $keyword => $weight) {
                if (strpos($featureLower, $keyword) !== false) {
                    $score += $weight;
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                $score += 1;
            }
        }

        return min($score, $maxScore);
    }

    private function calculateCancellationScore($policy)
    {
        $policyLower = strtolower($policy ?? '');

        if (strpos($policyLower, 'free') !== false || 
            strpos($policyLower, 'gratuit') !== false || 
            strpos($policyLower, 'gratuite') !== false || 
            strpos($policyLower, '48h') !== false ||
            strpos($policyLower, '48') !== false) {
            return 15;
        } elseif (strpos($policyLower, '24h') !== false ||
                  strpos($policyLower, '24') !== false) {
            return 10;
        } elseif (strpos($policyLower, '12h') !== false ||
                  strpos($policyLower, '12') !== false ||
                  strpos($policyLower, 'no refund') !== false ||
                  strpos($policyLower, 'non remboursable') !== false) {
            return 5;
        }

        return 7;
    }

    private function calculateAvailabilityScore($vehicle)
    {
        $bookingCount = $vehicle->bookings()->count();

        if ($bookingCount === 0) {
            return 5;
        }

        // Max available score at 20+ bookings
        $score = min(10, ($bookingCount / 20) * 10);
        return round($score, 2);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $vehicle = Vehicle::with('agency')->findOrFail($request->vehicle_id);
        
        $booking_data = $this->calculateBookingData(
            $vehicle,
            $request->start_date,
            $request->end_date
        );

        $booking_data['vehicle_id'] = $vehicle->id;

        return view('checkout', compact('vehicle', 'booking_data'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $vehicle = Vehicle::with('agency')->where('is_available', true)->findOrFail($request->vehicle_id);
        $booking_data = $this->calculateBookingData(
            $vehicle,
            $request->start_date,
            $request->end_date
        );

        // Payment is simulated for the academic demo; all financial fields are still server-calculated.
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $vehicle->id,
            'agency_id' => $vehicle->agency_id,
            'start_date' => $booking_data['start_date'],
            'end_date' => $booking_data['end_date'],
            'total_days' => $booking_data['days'],
            'subtotal' => $booking_data['subtotal'],
            'commission_rate' => $booking_data['commission_rate'],
            'commission_amount' => $booking_data['commission_amount'],
            'total_amount' => $booking_data['total'],
            'status' => 'confirmed',
        ]);

        return redirect()->route('booking.success', $booking->id);
    }

    public function success($id)
    {
        $booking = Booking::with(['vehicle', 'agency'])->findOrFail($id);
        $user = auth()->user();

        abort_unless(
            $booking->user_id === $user->id ||
            $user->role === 'admin' ||
            ($user->role === 'agency' && $user->agency?->id === $booking->agency_id),
            403
        );

        return view('success', compact('booking'));
    }

    private function calculateBookingData(Vehicle $vehicle, string $startDate, string $endDate): array
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = (int) $start->diffInDays($end);
        $subtotal = $days * $vehicle->price_per_day;
        $commission_rate = config('app.commission_rate', 10);
        $commission_amount = ($subtotal * $commission_rate) / 100;

        return [
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'days' => $days,
            'subtotal' => $subtotal,
            'commission_rate' => $commission_rate,
            'commission_amount' => $commission_amount,
            'total' => $subtotal + $commission_amount,
        ];
    }
}
