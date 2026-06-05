<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\User;
use App\Models\Booking;
use App\Models\Vehicle;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_agencies' => Agency::count(),
            'pending_agencies' => Agency::where('status', 'pending')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_bookings' => Booking::count(),
            'total_revenue' => Booking::where('status', 'completed')->sum('commission_amount'),
        ];

        $recent_agencies = Agency::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_agencies'));
    }

    public function agencies()
    {
        $agencies = Agency::with('user')->paginate(15);
        return view('admin.agencies.index', compact('agencies'));
    }

    public function approveAgency($id)
    {
        $agency = Agency::findOrFail($id);
        $agency->update(['status' => 'approved']);
        return back()->with('success', 'Agency approved successfully.');
    }

    public function rejectAgency($id)
    {
        $agency = Agency::findOrFail($id);
        $agency->update(['status' => 'rejected']);
        return back()->with('success', 'Agency rejected.');
    }
}
