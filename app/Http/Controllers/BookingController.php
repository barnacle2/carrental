<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'startDate' => 'required|date|after_or_equal:today',
            'duration' => 'required|integer|min:1',
            'paymentMethod' => 'required|in:card,cash',
            'license' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);

        // Store the license file
        $licensePath = $request->file('license')->store('licenses', 'public');

        // Create the booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'start_date' => $request->startDate,
            'duration' => $request->duration,
            'payment_method' => $request->paymentMethod,
            'license_path' => $licensePath,
            'total_amount' => $request->total,
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking completed successfully!');
    }
}
