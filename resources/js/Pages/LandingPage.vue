<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Header/Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <Link href="/">
                                <h1 class="text-2xl font-bold text-blue-600">Road Ready</h1>
                            </Link>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="flex items-center space-x-4">
                        <Link v-if="!$page.props.auth.user" 
                            href="/login" 
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium"
                        >
                            Login
                        </Link>
                        <Link v-if="!$page.props.auth.user"
                            href="/register"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
                        >
                            Sign Up
                        </Link>
                        <Link v-else
                            href="/dashboard"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium"
                        >
                            Dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block">Premium Car Rental</span>
                                <span class="block text-blue-600">For Your Journey</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Experience luxury and comfort with our premium car rental service. Choose from our wide selection of vehicles.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <Link href="/choose-cars"
                                        class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10"
                                    >
                                        Rent Now
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" 
                     src="/images/doydoy/bg1.jpg" 
                     alt="Luxury car">
            </div>
        </div>

        <!-- About Section -->
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">About Us</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Why Choose Our Car Rental?
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        We provide top-quality vehicles and exceptional service to ensure your journey is comfortable and memorable.
                    </p>
                </div>

                <div class="mt-10">
                    <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                        <div class="flex flex-col items-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">24/7 Support</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Round-the-clock customer support for your convenience.
                            </p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Best Prices</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Competitive rates and transparent pricing.
                            </p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Quality Assured</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Well-maintained vehicles for your safety.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cars Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Our Fleet</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Cars We Offer
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Sample Car Cards -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <img class="h-48 w-full object-cover" src="/images/doydoy/cars/sedan.jpg" alt="Luxury Sedan">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900">Luxury Sedan</h3>
                            <p class="mt-1 text-sm text-gray-500">Perfect for business trips and elegant occasions.</p>
                            <div class="mt-4">
                                <span class="text-blue-600 font-semibold">From ₱500/day</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <img class="h-48 w-full object-cover" src="/images/doydoy/cars/suv.jpg" alt="SUV">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900">SUV</h3>
                            <p class="mt-1 text-sm text-gray-500">Spacious and comfortable for family trips.</p>
                            <div class="mt-4">
                                <span class="text-blue-600 font-semibold">From ₱750/day</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <img class="h-48 w-full object-cover" src="/images/doydoy/cars/sportscar.jpg" alt="Sports Car">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900">Sports Car</h3>
                            <p class="mt-1 text-sm text-gray-500">Experience the thrill of luxury sports cars.</p>
                            <div class="mt-4">
                                <span class="text-blue-600 font-semibold">From ₱2000/day</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Company</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-gray-300 hover:text-white">About</a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-gray-300 hover:text-white">Careers</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Support</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-gray-300 hover:text-white">Contact</a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-gray-300 hover:text-white">FAQ</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Legal</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-gray-300 hover:text-white">Privacy</a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-gray-300 hover:text-white">Terms</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Connect</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-gray-300 hover:text-white">Facebook</a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-gray-300 hover:text-white">Twitter</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-700 pt-8">
                    <p class="text-base text-gray-400 text-center">
                        © 2024 CarRental. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
