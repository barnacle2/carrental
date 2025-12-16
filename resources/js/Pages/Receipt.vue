<template>
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-indigo-600 text-white p-6 text-center">
                <h1 class="text-3xl font-bold">Road Ready</h1>
                <p class="text-sm mt-1">Car Rental Service</p>
            </div>

            <!-- Receipt Content -->
            <div class="p-8">
                <!-- Receipt Header -->
                <div class="flex justify-between mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">RECEIPT</h2>
                        <p class="text-gray-600">Invoice #: {{ rental.id.toString().padStart(6, '0') }}</p>
                        <p class="text-gray-600">Date: {{ formatDate(rental.created_at) }}</p>
                    </div>
                    <div class="text-right">
                        <div class="flex flex-col items-center mb-2">
                            <img src="/images/doydoy/icon.png" alt="Road Ready Logo" class="h-16">
                        </div>
                        <p class="text-gray-600">014 Brgy. Mabua</p>
                        <p class="text-gray-600">Surigao, Philippines</p>
                    </div>
                </div>

                <!-- Client Information -->
                <div class="mb-8">
                    <h3 class="text-gray-800 font-bold mb-2">Client Information</h3>
                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <p class="text-gray-600"><span class="font-semibold">Name:</span> {{ rental.user.name }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Phone:</span> {{ rental.phone }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-gray-600"><span class="font-semibold">Address:</span> {{ rental.address }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Payment Method:</span> {{ rental.payment_method }}</p>
                        </div>
                    </div>
                </div>

                <!-- Rental Details -->
                <div class="mb-8">
                    <h3 class="text-gray-800 font-bold mb-4">Rental Details</h3>
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Car</th>
                                <th class="px-4 py-2 text-left">Duration</th>
                                <th class="px-4 py-2 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 border-t">{{ rental.car.name }}</td>
                                <td class="px-4 py-2 border-t">
                                    {{ formatDate(rental.start_date) }} - {{ formatDate(rental.end_date) }}
                                    <br>
                                    <span class="text-sm text-gray-600">({{ rental.duration }} days)</span>
                                </td>
                                <td class="px-4 py-2 border-t text-right">₱{{ formatPrice(rental.total_cost) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="px-4 py-2 text-right font-bold">Total</td>
                                <td class="px-4 py-2 text-right font-bold">₱{{ formatPrice(rental.total_cost) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Signature -->
                <div class="mt-12 pt-8 border-t">
                    <div class="flex justify-end">
                        <div class="text-center">
                            <div class="flex justify-center mb-2">
                                <img src="/images/signature.png" alt="Director's Signature" class="h-16">
                            </div>
                            <div class="border-b border-black w-48"></div>
                            <p class="mt-2 text-gray-600">Director's Signature</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 text-center text-gray-500 text-sm">
                <p>Thank you for choosing Road Ready!</p>
                <p>For inquiries, please contact us at support@roadready.com</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    rental: {
        type: Object,
        required: true
    }
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const formatPrice = (price) => {
    return Number(price).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
};
</script>
