<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('admin.dashboard')" class="text-2xl font-bold text-indigo-600">
                            Road Ready Admin
                        </Link>
                    </div>
                    <div class="flex items-center space-x-4">
                        <form @submit.prevent="submitLogout">
                            <button type="submit" class="text-gray-600 hover:text-indigo-600 transition">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const form = useForm({});

const submitLogout = () => {
    form.post(route('admin.logout'));
};
</script>
