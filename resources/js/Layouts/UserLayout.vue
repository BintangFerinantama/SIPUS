<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();
const mobileMenuOpen = ref(false);
</script>

<template>
    <div class="min-h-screen bg-pln-gray">
        <Head title="SIPUS" />

        <!-- Navigation Header -->
        <header class="bg-white border-b border-pln-gray shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <div class="items-center justify-center">
                                <img
                                    src="/pln.png"
                                    alt="Logo PLN"
                                    class="h-10 w-10 object-contain"
                                />
                            </div>
                            <div class="ml-3">
                                <span
                                    class="text-xl py-1 font-bold text-charcoal"
                                    >SIPUS</span
                                >
                                <span
                                    class="ml-2 px-2 py-1 text-xs bg-light-blue text-pln-blue rounded-full"
                                    >Dashboard User</span
                                >
                            </div>
                        </div>

                        <!-- Desktop Navigation -->
                        <nav class="hidden md:ml-10 md:flex md:space-x-8">
                            <Link
                                :href="route('dashboard')"
                                :class="[
                                    'inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                    route().current('dashboard')
                                        ? 'bg-light-blue text-pln-blue border border-pln-blue'
                                        : 'text-charcoal hover:text-dark-blue hover:bg-pln-gray',
                                ]"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"
                                    />
                                </svg>
                                Dashboard
                            </Link>

                            <Link
                                :href="route('files.index')"
                                :class="[
                                    'inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                    route().current('files.*')
                                        ? 'bg-light-blue text-pln-blue border border-pln-blue'
                                        : 'text-charcoal hover:text-dark-blue hover:bg-pln-gray',
                                ]"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                                Daftar File
                            </Link>

                            <Link
                                :href="route('tags.index')"
                                :class="[
                                    'inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                    route().current('tags.*')
                                        ? 'bg-light-blue text-pln-blue border border-pln-blue'
                                        : 'text-charcoal hover:text-dark-blue hover:bg-pln-gray',
                                ]"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                    />
                                </svg>
                                Tags
                            </Link>

                            <Link
                                :href="route('profile.edit')"
                                :class="[
                                    'inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200',
                                    route().current('profile.*')
                                        ? 'bg-light-blue text-pln-blue border border-pln-blue'
                                        : 'text-charcoal hover:text-dark-blue hover:bg-pln-gray',
                                ]"
                            >
                                <svg
                                    class="w-4 h-4 mr-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                Profile
                            </Link>
                        </nav>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center space-x-4">
                        <!-- User Info -->
                        <div
                            class="hidden md:flex md:items-center md:space-x-3"
                        >
                            <div class="text-right">
                                <div class="text-sm font-medium text-charcoal">
                                    {{ page.props.auth.user.name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{
                                        page.props.auth.user.instansi || "User"
                                    }}
                                </div>
                            </div>
                            <div
                                class="w-8 h-8 bg-dark-blue rounded-full flex items-center justify-center"
                            >
                                <span class="text-white text-sm font-medium">
                                    {{
                                        page.props.auth.user.name
                                            .charAt(0)
                                            .toUpperCase()
                                    }}
                                </span>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-charcoal hover:text-pln-red hover:bg-pln-gray rounded-lg transition-colors duration-200"
                        >
                            <svg
                                class="w-4 h-4 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                            Logout
                        </Link>

                        <!-- Mobile menu button -->
                        <button
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    v-if="!mobileMenuOpen"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    v-else
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div
                    v-if="mobileMenuOpen"
                    class="md:hidden border-t border-gray-200 pt-4 pb-4"
                >
                    <div class="space-y-2">
                        <Link
                            :href="route('dashboard')"
                            :class="[
                                'block px-3 py-2 text-base font-medium rounded-lg',
                                route().current('dashboard')
                                    ? 'bg-blue-50 text-blue-700'
                                    : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50',
                            ]"
                            @click="mobileMenuOpen = false"
                        >
                            Dashboard
                        </Link>

                        <Link
                            :href="route('files.index')"
                            :class="[
                                'block px-3 py-2 text-base font-medium rounded-lg',
                                route().current('files.*')
                                    ? 'bg-blue-50 text-blue-700'
                                    : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50',
                            ]"
                            @click="mobileMenuOpen = false"
                        >
                            My Files
                        </Link>

                        <Link
                            :href="route('tags.index')"
                            :class="[
                                'block px-3 py-2 text-base font-medium rounded-lg',
                                route().current('tags.*')
                                    ? 'bg-blue-50 text-blue-700'
                                    : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50',
                            ]"
                            @click="mobileMenuOpen = false"
                        >
                            Tags
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Header -->
        <div v-if="$slots.header" class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    <slot name="header" />
                </h1>
            </div>
        </div>

        <!-- Flash Messages -->
        <div
            v-if="page.props.flash?.success || page.props.flash?.error"
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4"
        >
            <div
                v-if="page.props.flash.success"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center"
                role="alert"
            >
                <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <span>{{ page.props.flash.success }}</span>
            </div>

            <div
                v-if="page.props.flash.error"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center"
                role="alert"
            >
                <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <span>{{ page.props.flash.error }}</span>
            </div>
        </div>

        <!-- Main content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="text-center text-sm text-gray-500">
                    © 2025 SIPUS - Sistem Penyimpanan Berkas. All rights
                    reserved.
                </div>
            </div>
        </footer>
    </div>
</template>
