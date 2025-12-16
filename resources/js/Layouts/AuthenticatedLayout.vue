<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const profileMenu = ref(false);
</script>

<template>
    <div>
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
                                    <span>{{ $page.props.auth.user.name }}</span>
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

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
