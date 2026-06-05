<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{
    public function dashboard()
    {
        $agency = Auth::user()->agency;
        
        if (!$agency) {
            return redirect('/')->with('error', 'Agency profile not found.');
        }

        $stats = [
            'total_vehicles' => $agency->vehicles()->count(),
            'total_bookings' => $agency->bookings()->count(),
            'total_revenue' => $agency->bookings()->where('status', 'completed')->sum('subtotal'),
            'pending_bookings' => $agency->bookings()->where('status', 'pending')->count(),
        ];

        $recent_bookings = $agency->bookings()->with(['user', 'vehicle'])->latest()->take(5)->get();

        return view('agency.dashboard', compact('agency', 'stats', 'recent_bookings'));
    }

    public function vehicles()
    {
        $vehicles = Auth::user()->agency->vehicles()->paginate(10);
        return view('agency.vehicles.index', compact('vehicles'));
    }

    public function createVehicle()
    {
        return view('agency.vehicles.create');
    }

    public function storeVehicle(Request $request)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'category' => 'required|in:suv,sedan,city,utility,luxury',
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        Auth::user()->agency->vehicles()->create([
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'category' => $request->category,
            'price_per_day' => $request->price_per_day,
            'description' => $request->description,
            'options' => [], // Add defaults or handle options
            'is_available' => true,
        ]);

        return redirect()->route('agency.vehicles')->with('success', 'Vehicle added successfully.');
    }
}
