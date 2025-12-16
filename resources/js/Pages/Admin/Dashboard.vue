<template>
    <Head title="Admin Dashboard" />
    <AdminLayout>
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100">
                        <i class="fas fa-users text-indigo-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ totalUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-car text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Cars</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ totalCars }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Bookings</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ totalBookings }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending Bookings</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ pendingBookings }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a :href="'/admin/users'" class="bg-white overflow-hidden shadow-sm rounded-xl p-6 hover:bg-gray-50 transition cursor-pointer">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100">
                        <i class="fas fa-user-cog text-indigo-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Manage Users</h3>
                        <p class="text-sm text-gray-500">View and manage user accounts</p>
                    </div>
                </div>
            </a>

            <a :href="'/admin/cars'" class="bg-white overflow-hidden shadow-sm rounded-xl p-6 hover:bg-gray-50 transition cursor-pointer">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-car-side text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Manage Cars</h3>
                        <p class="text-sm text-gray-500">Add and update available cars</p>
                    </div>
                </div>
            </a>

            <a :href="'/admin/bookings'" class="bg-white overflow-hidden shadow-sm rounded-xl p-6 hover:bg-gray-50 transition cursor-pointer">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Manage Bookings</h3>
                        <p class="text-sm text-gray-500">Review and process bookings</p>
                    </div>
                </div>
            </a>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    totalUsers: Number,
    totalCars: Number,
    totalBookings: Number,
    pendingBookings: Number
});
</script>
