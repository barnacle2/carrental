<template>
    <Head title="Checkout" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Complete Your Rental
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Car Details -->
                    <div class="md:col-span-1">
                        <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                            <img :src="car.image" :alt="car.name" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900">{{ car.name }}</h3>
                                <p class="text-sm text-gray-600">{{ car.type }} • {{ car.transmission }}</p>
                                
                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-car w-5"></i>
                                        {{ car.transmission }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-gas-pump w-5"></i>
                                        {{ car.fuel_type }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-money-bill w-5"></i>
                                        ₱{{ car.price_per_day }}/day
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Summary</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Daily Rate</span>
                                    <span class="font-medium">₱{{ car.price_per_day }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Duration</span>
                                    <span class="font-medium">{{ form.duration }} days</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">₱{{ calculateSubtotal }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tax (10%)</span>
                                    <span class="font-medium">₱{{ calculateTax }}</span>
                                </div>
                                <div class="pt-4 border-t">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold">Total</span>
                                        <span class="text-lg font-semibold text-indigo-600">₱{{ calculateTotal }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rental Form -->
                    <div class="md:col-span-2">
                        <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900">Rental Information</h3>
                                <form @submit.prevent="submitForm" class="mt-6 space-y-6">
                                    <!-- Personal Information -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                            <input 
                                                type="text" 
                                                v-model="form.name"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required
                                            >
                                            <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                            <input 
                                                type="tel" 
                                                v-model="form.phone"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required
                                            >
                                            <div v-if="form.errors.phone" class="mt-1 text-sm text-red-600">{{ form.errors.phone }}</div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea 
                                            v-model="form.address"
                                            rows="3"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required
                                        ></textarea>
                                        <div v-if="form.errors.address" class="mt-1 text-sm text-red-600">{{ form.errors.address }}</div>
                                    </div>

                                    <!-- Rental Period -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                            <input 
                                                type="date" 
                                                v-model="form.startDate"
                                                :min="minDate"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required
                                            >
                                            <div v-if="form.errors.startDate" class="mt-1 text-sm text-red-600">{{ form.errors.startDate }}</div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Duration (Days)</label>
                                            <input 
                                                type="number" 
                                                v-model="form.duration"
                                                min="1"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required
                                            >
                                            <div v-if="form.errors.duration" class="mt-1 text-sm text-red-600">{{ form.errors.duration }}</div>
                                        </div>
                                    </div>

                                    <!-- Driver's License -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Driver's License</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="space-y-1 text-center">
                                                <div v-if="!form.license" class="flex flex-col items-center">
                                                    <i class="fas fa-upload text-gray-400 text-3xl mb-4"></i>
                                                    <div class="flex text-sm text-gray-600">
                                                        <label
                                                            for="license-upload"
                                                            class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                                                        >
                                                            <span>Upload a file</span>
                                                            <input 
                                                                id="license-upload" 
                                                                name="license-upload" 
                                                                type="file" 
                                                                class="sr-only"
                                                                accept=".jpg,.jpeg,.png,.pdf"
                                                                @change="handleLicenseUpload"
                                                            >
                                                        </label>
                                                        <p class="pl-1">or drag and drop</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500">
                                                        PNG, JPG, or PDF up to 10MB
                                                    </p>
                                                </div>
                                                <div v-else class="flex flex-col items-center">
                                                    <i class="fas fa-file text-indigo-600 text-3xl mb-2"></i>
                                                    <p class="text-sm text-gray-900">{{ form.license.name }}</p>
                                                    <button 
                                                        type="button"
                                                        class="mt-2 text-sm text-red-600 hover:text-red-800"
                                                        @click="removeLicense"
                                                    >
                                                        Remove file
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="form.errors.license" class="mt-1 text-sm text-red-600">{{ form.errors.license }}</div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-4">Payment Method</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div 
                                                class="relative border rounded-lg p-4 cursor-pointer"
                                                :class="{ 'border-indigo-600 bg-indigo-50': form.paymentMethod === 'card', 'border-gray-300 hover:border-indigo-500': form.paymentMethod !== 'card' }"
                                                @click="form.paymentMethod = 'card'"
                                            >
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-credit-card text-xl" :class="form.paymentMethod === 'card' ? 'text-indigo-600' : 'text-gray-400'"></i>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium" :class="form.paymentMethod === 'card' ? 'text-indigo-900' : 'text-gray-900'">Credit/Debit Card</h3>
                                                        <p class="text-xs text-gray-500">Pay with your card</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div 
                                                class="relative border rounded-lg p-4 cursor-pointer"
                                                :class="{ 'border-indigo-600 bg-indigo-50': form.paymentMethod === 'cash', 'border-gray-300 hover:border-indigo-500': form.paymentMethod !== 'cash' }"
                                                @click="form.paymentMethod = 'cash'"
                                            >
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-money-bill text-xl" :class="form.paymentMethod === 'cash' ? 'text-indigo-600' : 'text-gray-400'"></i>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium" :class="form.paymentMethod === 'cash' ? 'text-indigo-900' : 'text-gray-900'">Cash on Pickup</h3>
                                                        <p class="text-xs text-gray-500">Pay when you pick up the car</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="form.errors.paymentMethod" class="mt-1 text-sm text-red-600">{{ form.errors.paymentMethod }}</div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="flex items-center justify-end space-x-4">
                                        <Link
                                            :href="route('cars.show', car.id)"
                                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            Cancel
                                        </Link>
                                        <button
                                            type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            :disabled="form.processing"
                                        >
                                            <i v-if="form.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                            Complete Booking
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    car: {
        type: Object,
        required: true
    }
});

const form = useForm({
    name: '',
    phone: '',
    address: '',
    startDate: '',
    duration: 7,
    paymentMethod: 'cash',
    license: null,
    total: 0
});

const minDate = new Date().toISOString().split('T')[0];

const calculateSubtotal = computed(() => {
    return form.duration * props.car.price_per_day;
});

const calculateTax = computed(() => {
    return calculateSubtotal.value * 0.10;
});

const calculateTotal = computed(() => {
    return calculateSubtotal.value + calculateTax.value;
});

const handleLicenseUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 10 * 1024 * 1024) { // 10MB limit
            form.errors.license = "File size must be less than 10MB";
            return;
        }
        form.license = file;
    }
};

const removeLicense = () => {
    form.license = null;
};

const submitForm = () => {
    // Set the total before submitting
    form.total = calculateTotal.value;

    // Create FormData object for file upload
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('phone', form.phone);
    formData.append('address', form.address);
    formData.append('startDate', form.startDate);
    formData.append('duration', form.duration);
    formData.append('paymentMethod', form.paymentMethod);
    formData.append('total', form.total);
    
    if (form.license) {
        formData.append('license', form.license);
    }

    form.post(route('rentals.store', { car: props.car.id }), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            alert('Booking completed successfully!');
            window.location = route('dashboard');
        },
        onError: (errors) => {
            console.error('Booking failed:', errors);
        }
    });
};
</script>
