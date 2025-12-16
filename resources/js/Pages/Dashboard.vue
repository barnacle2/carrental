<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <!-- Navigation Bar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('dashboard')" class="text-2xl font-bold text-indigo-600">
                            Road Ready
                        </Link>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link :href="route('cars.index')" class="text-gray-600 hover:text-indigo-600 transition">
                            Choose Cars
                        </Link>
                        <div class="relative" @click="profileMenu = !profileMenu">
                            <button class="flex items-center space-x-2 text-gray-600 hover:text-indigo-600 transition">
                                <span>{{ auth.user.name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <!-- Profile Dropdown -->
                            <div v-if="profileMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                                <Link :href="route('profile.edit')" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">
                                    Profile Settings
                                </Link>
                                <Link :href="route('logout')" method="post" as="button" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-indigo-50">
                                    Logout
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Welcome Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth.user.name }}!</h1>
                        <p class="text-gray-600 mt-1">Here's what's happening with your rentals.</p>
                    </div>
                    <Link :href="route('cars.index')" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-car mr-2"></i>
                        Rent a Car
                    </Link>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-car-side text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Active Rentals</p>
                            <p class="text-2xl font-bold text-gray-900">{{ ongoingRentals.filter(rental => rental.status === 'confirmed').length }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Completed Rentals</p>
                            <p class="text-2xl font-bold text-gray-900">{{ pastRentals.length }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i class="fas fa-wallet text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Spent</p>
                            <p class="text-2xl font-bold text-gray-900">₱{{ formatPrice(totalSpent) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rentals Section -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">Your Rentals</h2>
                        <nav class="flex space-x-8" aria-label="Tabs">
                            <button
                                @click="activeTab = 'pending'"
                                :class="[
                                    activeTab === 'pending'
                                        ? 'border-blue-500 text-blue-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
                                ]"
                            >
                                Pending
                                <span
                                    :class="[
                                        activeTab === 'pending' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-900',
                                        'ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium'
                                    ]"
                                >
                                    {{ pendingRentals.length }}
                                </span>
                            </button>

                            <button
                                @click="activeTab = 'ongoing'"
                                :class="[
                                    activeTab === 'ongoing'
                                        ? 'border-blue-500 text-blue-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
                                ]"
                            >
                                Ongoing
                                <span
                                    :class="[
                                        activeTab === 'ongoing' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-900',
                                        'ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium'
                                    ]"
                                >
                                    {{ ongoingRentals.filter(rental => rental.status === 'confirmed').length }}
                                </span>
                            </button>

                            <button
                                @click="activeTab = 'past'"
                                :class="[
                                    activeTab === 'past'
                                        ? 'border-blue-500 text-blue-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm'
                                ]"
                            >
                                Past Rentals
                                <span
                                    :class="[
                                        activeTab === 'past' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-900',
                                        'ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium'
                                    ]"
                                >
                                    {{ pastRentals.length }}
                                </span>
                            </button>
                        </nav>
                    </div>
                </div>

                <div class="mt-6">
                    <!-- Pending Rentals -->
                    <div v-if="activeTab === 'pending'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="rental in pendingRentals" :key="rental.id" class="bg-white border rounded-xl overflow-hidden hover:shadow-md transition">
                            <img :src="rental.car?.image" :alt="rental.car?.name" class="w-full h-48 object-cover"/>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900">{{ rental.car?.name || 'Car Unavailable' }}</h3>
                                <div class="mt-2 space-y-2 text-sm text-gray-600">
                                    <p class="flex items-center">
                                        <i class="fas fa-calendar-alt w-5"></i>
                                        {{ formatDate(rental.start_date) }} - {{ formatDate(rental.end_date) }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-money-bill-wave w-5"></i>
                                        ₱{{ formatPrice(rental.total_cost) }}
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-if="pendingRentals.length === 0" class="col-span-full text-center py-12">
                            <i class="fas fa-clock text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">No pending rentals</p>
                        </div>
                    </div>

                    <!-- Ongoing Rentals -->
                    <div v-if="activeTab === 'ongoing'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="rental in ongoingRentals.filter(rental => rental.status === 'confirmed')" :key="rental.id" class="bg-white border rounded-xl overflow-hidden hover:shadow-md transition">
                            <img :src="rental.car.image" :alt="rental.car.name" class="w-full h-48 object-cover"/>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900">{{ rental.car.name }}</h3>
                                <div class="mt-2 space-y-2 text-sm text-gray-600">
                                    <p class="flex items-center">
                                        <i class="fas fa-calendar-alt w-5"></i>
                                        {{ formatDate(rental.start_date) }} - {{ formatDate(rental.end_date) }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-money-bill-wave w-5"></i>
                                        ₱{{ formatPrice(rental.total_cost) }}
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ rental.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-if="ongoingRentals.filter(rental => rental.status === 'confirmed').length === 0" class="col-span-full text-center py-12">
                            <i class="fas fa-car-side text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">No ongoing rentals</p>
                            <Link :href="route('cars.index')" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-700">
                                Browse available cars
                                <i class="fas fa-arrow-right ml-2"></i>
                            </Link>
                        </div>
                    </div>

                    <!-- Past Rentals -->
                    <div v-if="activeTab === 'past'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="rental in pastRentals" :key="rental.id" class="bg-white border rounded-xl overflow-hidden hover:shadow-md transition">
                            <img :src="rental.car.image" :alt="rental.car.name" class="w-full h-48 object-cover"/>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900">{{ rental.car.name }}</h3>
                                <div class="mt-2 space-y-2 text-sm text-gray-600">
                                    <p class="flex items-center">
                                        <i class="fas fa-calendar-alt w-5"></i>
                                        {{ formatDate(rental.start_date) }} - {{ formatDate(rental.end_date) }}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-money-bill-wave w-5"></i>
                                        ₱{{ formatPrice(rental.total_cost) }}
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                </div>
                                <Link 
                                    :href="route('rentals.receipt', rental.id)"
                                    target="_blank"
                                    class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700"
                                >
                                    <i class="fas fa-receipt mr-1"></i>
                                    View Receipt
                                </Link>
                            </div>
                        </div>
                        <div v-if="pastRentals.length === 0" class="col-span-full text-center py-12">
                            <i class="fas fa-history text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">No rental history yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    auth: Object,
    ongoingRentals: {
        type: Array,
        default: () => []
    },
    pastRentals: {
        type: Array,
        default: () => []
    },
    pendingRentals: {
        type: Array,
        default: () => []
    }
});

const activeTab = ref('pending');
const profileMenu = ref(false);

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-PH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function formatPrice(price) {
    if (!price) return '0.00';
    return Number(price).toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

const totalSpent = computed(() => {
    return [...props.ongoingRentals.filter(rental => rental.status === 'confirmed'), ...props.pastRentals]
        .reduce((total, rental) => total + Number(rental.total_cost || 0), 0);
});
</script>
