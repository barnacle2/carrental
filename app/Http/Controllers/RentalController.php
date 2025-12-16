<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RentalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $rentals = [
            'pendingRentals' => $user->rentals()->where('status', 'pending')->get(),
            'ongoingRentals' => $user->rentals()->where('status', 'confirmed')->get(),
            'pastRentals' => $user->rentals()->where('status', 'completed')->get(),
        ];

        return Inertia::render('Dashboard', $rentals);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'startDate' => 'required|date|after_or_equal:today',
            'duration' => 'required|integer|min:1',
            'paymentMethod' => 'required|in:cash,card',
            'license' => 'required|file|max:10240', // 10MB limit
            'total' => 'required|numeric|min:0'
        ]);

        // Handle license file upload first
        $licensePath = null;
        if ($request->hasFile('license')) {
            $licensePath = $request->file('license')->store('licenses', 'public');
        }

        // Calculate end date based on start date and duration
        $endDate = date('Y-m-d', strtotime($validated['startDate'] . ' + ' . $validated['duration'] . ' days'));

        $rental = auth()->user()->rentals()->create([
            'car_id' => $request->route('car'),
            'start_date' => $validated['startDate'],
            'end_date' => $endDate,
            'duration' => $validated['duration'],
            'total_cost' => $validated['total'],
            'status' => 'pending',
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'payment_method' => $validated['paymentMethod'],
            'license_path' => $licensePath
        ]);

        return redirect()->route('dashboard')->with('success', 'Rental request submitted successfully!');
    }

    public function update(Request $request, Rental $rental)
    {
        if ($request->user()->cannot('update', $rental)) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $rental->update($validated);

        return redirect()->back()->with('success', 'Rental status updated successfully!');
    }

    public function destroy(Rental $rental)
    {
        if (auth()->user()->cannot('delete', $rental)) {
            abort(403);
        }

        $rental->delete();

        return redirect()->route('dashboard')->with('success', 'Rental cancelled successfully!');
    }

    public function showReceipt(Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Receipt', [
            'rental' => $rental->load(['user', 'car']),
        ]);
    }
}