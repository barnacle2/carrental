<template>
    <Head title="Manage Bookings" />
    <AdminLayout>
        <div class="p-6 bg-white rounded-lg shadow">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Bookings</h1>
            
            <div v-if="error" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ error }}
            </div>

            <div v-if="bookings.data && bookings.data.length === 0" class="text-center py-4 text-gray-500">
                No bookings found.
            </div>

            <div v-else class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Car Details
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rental Period
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                License
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Price
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="booking in bookings.data" :key="booking.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ booking.user.name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ booking.user.email }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ booking.car?.name || 'Car Unavailable' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Type: {{ booking.car?.type || 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ booking.start_date ? formatDate(booking.start_date) : 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    to {{ booking.end_date ? formatDate(booking.end_date) : 'N/A' }}
                                </div>
                                <div class="text-sm font-medium text-indigo-600 mt-1">
                                    {{ booking.duration }} {{ booking.duration === 1 ? 'day' : 'days' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 flex-shrink-0 cursor-pointer" @click="showLicenseModal(booking)">
                                        <img 
                                            v-if="booking.license_path" 
                                            :src="'/storage/' + booking.license_path"
                                            class="h-12 w-12 object-cover rounded-lg hover:opacity-75 transition-opacity"
                                            alt="License"
                                        />
                                        <div v-else class="h-12 w-12 bg-gray-100 flex items-center justify-center rounded-lg">
                                            <span class="text-xs text-gray-500">No license</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ booking.total_cost || booking.total_price || '0.00' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="[
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    {
                                        'bg-yellow-100 text-yellow-800': booking.status === 'pending',
                                        'bg-green-100 text-green-800': booking.status === 'confirmed',
                                        'bg-red-100 text-red-800': booking.status === 'cancelled'
                                    }
                                ]">
                                    {{ booking.status.charAt(0).toUpperCase() + booking.status.slice(1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button 
                                    v-if="booking.status === 'pending'"
                                    @click="updateBookingStatus(booking.id, 'confirmed')"
                                    class="text-green-600 hover:text-green-900 mr-3"
                                >
                                    Confirm
                                </button>
                                <button 
                                    v-if="booking.status === 'pending'"
                                    @click="updateBookingStatus(booking.id, 'cancelled')"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Cancel
                                </button>
                                <button 
                                    v-if="booking.status === 'confirmed'"
                                    @click="updateBookingStatus(booking.id, 'completed')"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    Complete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- License Modal -->
            <TransitionRoot appear :show="isLicenseModalOpen" as="template">
                <Dialog as="div" @close="closeLicenseModal" class="relative z-10">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <div class="fixed inset-0 bg-black bg-opacity-25" />
                    </TransitionChild>

                    <div class="fixed inset-0 overflow-y-auto">
                        <div class="flex min-h-full items-center justify-center p-4 text-center">
                            <TransitionChild
                                as="template"
                                enter="duration-300 ease-out"
                                enter-from="opacity-0 scale-95"
                                enter-to="opacity-100 scale-100"
                                leave="duration-200 ease-in"
                                leave-from="opacity-100 scale-100"
                                leave-to="opacity-0 scale-95"
                            >
                                <DialogPanel class="w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                                    <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900 mb-4">
                                        License Photo
                                    </DialogTitle>
                                    <div class="mt-2">
                                        <img 
                                            v-if="selectedBooking?.license_path"
                                            :src="'/storage/' + selectedBooking.license_path"
                                            class="w-full rounded-lg"
                                            alt="License"
                                        />
                                    </div>
                                    <div class="mt-4">
                                        <button
                                            type="button"
                                            class="inline-flex justify-center rounded-md border border-transparent bg-gray-100 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                                            @click="closeLicenseModal"
                                        >
                                            Close
                                        </button>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>

            <!-- Pagination -->
            <div class="mt-6">
                <Pagination :links="bookings.links" />
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';

const props = defineProps({
    bookings: Object,
    error: String
});

const isLicenseModalOpen = ref(false);
const selectedBooking = ref(null);

function showLicenseModal(booking) {
    selectedBooking.value = booking;
    isLicenseModalOpen.value = true;
}

function closeLicenseModal() {
    isLicenseModalOpen.value = false;
    selectedBooking.value = null;
}

onMounted(() => {
    console.log('Bookings data:', props.bookings);
});

function formatDate(date) {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function updateBookingStatus(bookingId, status) {
    router.put(`/admin/bookings/${bookingId}/status`, { status }, {
        onSuccess: () => {
            console.log('Status updated successfully');
        },
        onError: (errors) => {
            console.error('Error updating status:', errors);
        }
    });
}
</script>
