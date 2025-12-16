<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Admin/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard', [
            'totalUsers' => User::count(),
            'totalCars' => Car::count(),
            'totalBookings' => Rental::count(),
            'pendingBookings' => Rental::where('status', 'pending')->count(),
        ]);
    }

    public function showUsers()
    {
        return Inertia::render('Admin/Users', [
            'users' => User::query()
                ->withCount('rentals')
                ->latest()
                ->paginate(10)
        ]);
    }

    public function showCars()
    {
        return Inertia::render('Admin/Cars', [
            'cars' => Car::latest()->paginate(10)
        ]);
    }

    public function showBookings()
    {
        try {
            // First check if the tables exist
            if (!Schema::hasTable('rentals')) {
                throw new \Exception('Rentals table does not exist');
            }

            $bookings = Rental::with(['user', 'car'])
                ->latest()
                ->paginate(10);

            // Log the bookings data for debugging
            \Log::info('Bookings loaded:', [
                'count' => $bookings->count(),
                'total' => $bookings->total()
            ]);

            return Inertia::render('Admin/Bookings', [
                'bookings' => $bookings
            ]);
        } catch (\Exception $e) {
            // Log the full error with stack trace
            \Log::error('Error loading bookings: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return Inertia::render('Admin/Bookings', [
                'bookings' => [
                    'data' => [],
                    'links' => []
                ],
                'error' => 'Failed to load bookings: ' . $e->getMessage()
            ]);
        }
    }

    public function storeCar(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'transmission' => 'required|string|in:Manual,Automatic',
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'is_available' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cars', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        // Convert is_available to boolean
        $validated['is_available'] = filter_var($validated['is_available'], FILTER_VALIDATE_BOOLEAN);

        Car::create($validated);

        return redirect()->back()->with('success', 'Car added successfully');
    }

    public function updateCar(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'transmission' => 'required|string|in:Manual,Automatic',
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'is_available' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($car->image && Storage::disk('public')->exists(str_replace('/storage/', '', $car->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $car->image));
            }
            
            $path = $request->file('image')->store('cars', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        // Convert is_available to boolean
        $validated['is_available'] = filter_var($validated['is_available'], FILTER_VALIDATE_BOOLEAN);

        $car->update($validated);

        return redirect()->back()->with('success', 'Car updated successfully');
    }

    public function deleteCar(Car $car)
    {
        $car->delete();
        return redirect()->back();
    }

    public function updateBookingStatus(Request $request, Rental $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking->update($validated);

        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
