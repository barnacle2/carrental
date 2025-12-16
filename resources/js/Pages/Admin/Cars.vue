<template>
    <Head title="Manage Cars" />
    <AdminLayout>
        <div class="p-6 bg-white rounded-lg shadow">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Cars</h1>
                <button
                    @click="showAddCarModal = true"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                >
                    Add New Car
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Car
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Transmission
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price/Day
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
                        <tr v-for="car in cars.data" :key="car.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img :src="car.image" class="h-10 w-10 rounded-full object-cover" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ car.name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ car.type }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ car.type }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ car.transmission }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ₱{{ formatPrice(car.price_per_day) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="[
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    car.is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                ]">
                                    {{ car.is_available ? 'Available' : 'Rented' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button 
                                    @click="editCar(car)"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3"
                                >
                                    Edit
                                </button>
                                <button 
                                    @click="deleteCar(car)"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                <Pagination :links="cars.links" />
            </div>
        </div>

        <!-- Add/Edit Car Modal -->
        <Modal :show="showAddCarModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ editingCar ? 'Edit Car' : 'Add New Car' }}
                </h2>
                <form @submit.prevent="submitCar" class="mt-6">
                    <div class="space-y-4">
                        <div>
                            <InputLabel for="name" value="Car Name" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div>
                            <InputLabel for="type" value="Car Type" />
                            <TextInput
                                id="type"
                                v-model="form.type"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div>
                            <InputLabel for="transmission" value="Transmission" />
                            <select
                                id="transmission"
                                v-model="form.transmission"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Select Transmission</option>
                                <option value="Manual">Manual</option>
                                <option value="Automatic">Automatic</option>
                            </select>
                        </div>

                        <div>
                            <InputLabel for="price_per_day" value="Price per Day (₱)" />
                            <TextInput
                                id="price_per_day"
                                v-model="form.price_per_day"
                                type="number"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3"
                                required
                            ></textarea>
                        </div>

                        <div>
                            <InputLabel for="image" value="Car Image" />
                            <div class="mt-1 flex items-center space-x-4">
                                <div v-if="imagePreview" class="h-24 w-24 relative">
                                    <img :src="imagePreview" class="h-24 w-24 rounded-lg object-cover" />
                                    <button 
                                        @click="removeImage" 
                                        type="button"
                                        class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 hover:bg-red-200"
                                    >
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <label 
                                    class="cursor-pointer px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition flex items-center"
                                >
                                    <i class="fas fa-upload mr-2"></i>
                                    Upload Image
                                    <input
                                        type="file"
                                        class="hidden"
                                        accept="image/*"
                                        @change="handleImageUpload"
                                    />
                                </label>
                            </div>
                            <p v-if="form.errors && form.errors.image" class="mt-1 text-sm text-red-600">{{ form.errors.image }}</p>
                        </div>

                        <div class="flex items-center">
                            <input
                                id="is_available"
                                v-model="form.is_available"
                                type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            />
                            <InputLabel for="is_available" value="Available" class="ml-2" />
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal" class="mr-3">
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton :disabled="form.processing">
                            {{ editingCar ? 'Update' : 'Create' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    cars: Object
});

const showAddCarModal = ref(false);
const editingCar = ref(null);
const form = ref({
    name: '',
    type: '',
    transmission: '',
    price_per_day: '',
    description: '',
    image: null,
    is_available: true
});

const imagePreview = ref(null);

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (file) {
        // Check file size (10MB = 10 * 1024 * 1024 bytes)
        const maxSize = 10 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('Image size must be less than 10MB');
            event.target.value = ''; // Clear the file input
            return;
        }

        form.value.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    form.value.image = null;
    imagePreview.value = null;
}

function editCar(car) {
    editingCar.value = car;
    form.value = {
        name: car.name,
        type: car.type,
        transmission: car.transmission,
        price_per_day: car.price_per_day,
        description: car.description,
        image: null,
        is_available: car.is_available
    };
    imagePreview.value = car.image;
    showAddCarModal.value = true;
}

function closeModal() {
    showAddCarModal.value = false;
    editingCar.value = null;
    form.value = {
        name: '',
        type: '',
        transmission: '',
        price_per_day: '',
        description: '',
        image: null,
        is_available: true
    };
    imagePreview.value = null;
}

function submitCar() {
    console.log('Submitting form:', form.value);
    
    // Create FormData object
    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('type', form.value.type);
    formData.append('transmission', form.value.transmission);
    formData.append('price_per_day', form.value.price_per_day.toString());
    formData.append('description', form.value.description);
    formData.append('is_available', form.value.is_available ? '1' : '0');
    
    if (form.value.image) {
        formData.append('image', form.value.image);
    }

    if (editingCar.value) {
        // Add _method field for PUT request
        formData.append('_method', 'PUT');
        
        router.post(`/admin/cars/${editingCar.value.id}`, formData, {
            onSuccess: () => closeModal(),
            onError: (errors) => console.error('Submission errors:', errors),
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    } else {
        router.post('/admin/cars', formData, {
            onSuccess: () => closeModal(),
            onError: (errors) => console.error('Submission errors:', errors),
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    }
}

function deleteCar(car) {
    if (confirm('Are you sure you want to delete this car?')) {
        router.delete(`/admin/cars/${car.id}`);
    }
}

function formatPrice(price) {
    return new Intl.NumberFormat('en-PH').format(price);
}
</script>
