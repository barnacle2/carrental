<template>
    <Head title="Choose a Car" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Choose Your Car
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filters -->
                <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Car Type</label>
                            <select v-model="filters.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                <option value="sedan">Sedan</option>
                                <option value="suv">SUV</option>
                                <option value="sports">Sports Car</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price Range</label>
                            <select v-model="filters.priceRange" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Prices</option>
                                <option value="0-2500">₱0 - ₱2,500 per day</option>
                                <option value="2501-5000">₱2,501 - ₱5,000 per day</option>
                                <option value="5001+">₱5,001+ per day</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Transmission</label>
                            <select v-model="filters.transmission" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                <option value="automatic">Automatic</option>
                                <option value="manual">Manual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sort By</label>
                            <select v-model="filters.sortBy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="price_asc">Price: Low to High</option>
                                <option value="price_desc">Price: High to Low</option>
                                <option value="name">Name</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Car Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="car in filteredCars" :key="car.id" class="bg-white overflow-hidden shadow-sm rounded-xl hover:shadow-md transition">
                        <img :src="car.image" :alt="car.name" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ car.name }}</h3>
                                    <p class="text-sm text-gray-600">{{ car.type }} • {{ car.transmission }}</p>
                                </div>
                                <p class="text-lg font-bold text-indigo-600">₱{{ car.price_per_day }}/day</p>
                            </div>
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-users w-5"></i>
                                    <span>{{ car.seats }} Seats</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-gas-pump w-5"></i>
                                    <span>{{ car.fuel_type }}</span>
                                </div>
                            </div>
                            <Link 
                                :href="route('cars.show', car.id)"
                                class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                            >
                                Rent Now
                                <i class="fas fa-arrow-right ml-2"></i>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    cars: Array
});

const filters = ref({
    type: '',
    priceRange: '',
    transmission: '',
    sortBy: 'price_asc'
});

const filteredCars = computed(() => {
    let result = [...props.cars];

    // Filter by type
    if (filters.value.type) {
        result = result.filter(car => car.type.toLowerCase() === filters.value.type);
    }

    // Filter by transmission
    if (filters.value.transmission) {
        result = result.filter(car => car.transmission.toLowerCase() === filters.value.transmission);
    }

    // Filter by price range
    if (filters.value.priceRange) {
        const [min, max] = filters.value.priceRange.split('-').map(Number);
        result = result.filter(car => {
            if (max) {
                return car.price_per_day >= min && car.price_per_day <= max;
            } else {
                return car.price_per_day >= min;
            }
        });
    }

    // Sort
    result.sort((a, b) => {
        switch (filters.value.sortBy) {
            case 'price_asc':
                return a.price_per_day - b.price_per_day;
            case 'price_desc':
                return b.price_per_day - a.price_per_day;
            case 'name':
                return a.name.localeCompare(b.name);
            default:
                return 0;
        }
    });

    return result;
});
</script>
