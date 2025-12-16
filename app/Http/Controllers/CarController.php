<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::where('is_available', true)->get();
        return Inertia::render('ChooseCars', [
            'cars' => $cars
        ]);
    }

    public function show(Car $car)
    {
        return Inertia::render('Checkout', [
            'car' => $car
        ]);
    }
}
