<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();

const props = defineProps({
    stats: Object,
    recentFiles: Array,
    racks: Array,
});

// Check if current user is admin
const isAdmin = computed(() => page.props.auth.user.role === "admin");

// Get appropriate layout component
const LayoutComponent = computed(() =>
    isAdmin.value ? AdminLayout : UserLayout
);

// Stats for Admin
const adminStatCards = computed(() => [
    {
        title: "Total Files",
        subtitle: "In System",
        value: props.stats?.totalFiles || 0,
        icon: "M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z",
        color: "blue",
    },
    {
        title: "Total Racks",
        subtitle: "Available",
        value: props.stats?.totalRacks || 0,
        icon: "M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10",
        color: "green",
    },
    {
        title: "Total Storage",
        subtitle: "Used",
        value: props.stats?.totalStorage || "0 MB",
        icon: "M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4",
        color: "purple",
    },
    {
        title: "Active Users",
        subtitle: "Approved",
        value: props.stats?.activeUsers || 0,
        icon: "M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z",
        color: "yellow",
    },
    {
        title: "Pending Users",
        subtitle: "Need Approval",
        value: props.stats?.pendingUsers || 0,
        icon: "M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z",
        color: "red",
    },
]);

// Stats for User
const userStatCards = computed(() => [
    {
        title: "File Saya",
        subtitle: "Terupload",
        value: props.stats?.myFiles || 0,
        icon: "M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z",
        color: "blue",
    },
    {
        title: "Total Penyimpanan",
        subtitle: "Dari Akun Saya",
        value: props.stats?.myStorage || "0 MB",
        icon: "M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4",
        color: "green",
    },
    {
        title: "Terakhir Diupload",
        subtitle: "Minggu Ini",
        value: props.stats?.recentUploads || 0,
        icon: "M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12",
        color: "purple",
    },
    {
        title: "Downloads",
        subtitle: "File Saya",
        value: props.stats?.downloadCount || 0,
        icon: "M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z",
        color: "yellow",
    },
]);

// Choose appropriate stats based on role
const statCards = computed(() =>
    isAdmin.value ? adminStatCards.value : userStatCards.value
);
</script>

<template>
    <Head :title="isAdmin ? 'Admin Dashboard - SIPUS' : 'Dashboard - SIPUS'" />

    <component :is="LayoutComponent">
        <template #header>
            {{ isAdmin ? "Admin Dashboard" : "My Dashboard" }}
        </template>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div
                v-for="(card, index) in statCards"
                :key="index"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            :class="[
                                'w-12 h-12 rounded-lg flex items-center justify-center',
                                card.color === 'blue' ? 'bg-light-blue' : '',
                                card.color === 'green' ? 'bg-green-100' : '',
                                card.color === 'purple' ? 'bg-purple-100' : '',
                                card.color === 'yellow' ? 'bg-yellow-100' : '',
                                card.color === 'red' ? 'bg-red-100' : '',
                            ]"
                        >
                            <svg
                                :class="[
                                    'w-6 h-6',
                                    card.color === 'blue'
                                        ? 'text-blue-600'
                                        : '',
                                    card.color === 'green'
                                        ? 'text-green-600'
                                        : '',
                                    card.color === 'purple'
                                        ? 'text-purple-600'
                                        : '',
                                    card.color === 'yellow'
                                        ? 'text-yellow-600'
                                        : '',
                                    card.color === 'red' ? 'text-red-600' : '',
                                ]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="card.icon"
                                />
                            </svg>
                        </div>
                    </div>
                    <div
                        v-if="card.badge"
                        :class="[
                            'px-2 py-1 text-xs font-medium rounded-full',
                            card.badge === 'New'
                                ? 'bg-green-100 text-green-800'
                                : '',
                            card.badge === 'Action Required'
                                ? 'bg-red-100 text-red-800'
                                : '',
                        ]"
                    >
                        {{ card.badge }}
                    </div>
                </div>

                <div class="mt-4">
                    <div class="text-2xl font-bold text-gray-900">
                        {{ card.value }}
                    </div>
                    <div class="text-sm text-gray-600 font-medium">
                        {{ card.title }}
                    </div>
                    <div class="text-xs text-gray-500">{{ card.subtitle }}</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8"
        >
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Fitur Utama
            </h3>

            <!-- Admin Actions -->
            <div v-if="isAdmin" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <Link
                    :href="route('files.index')"
                    class="flex items-center p-4 bg-light-blue rounded-lg hover:bg-pln-blue hover:text-white transition-colors duration-200"
                >
                    <div
                        class="w-10 h-10 bg-pln-blue rounded-lg flex items-center justify-center mr-3"
                    >
                        <svg
                            class="w-5 h-5 text-white"
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
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            Manage Files
                        </div>
                        <div class="text-xs text-gray-500">Lihat Semua File</div>
                    </div>
                </Link>

                <Link
                    :href="route('admin.users.index')"
                    class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200"
                >
                    <div
                        class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3"
                    >
                        <svg
                            class="w-5 h-5 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                            />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            Manage Users
                        </div>
                        <div class="text-xs text-gray-500">Persetujuan User</div>
                    </div>
                </Link>

                <Link
                    :href="route('admin.racks.index')"
                    class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200"
                >
                    <div
                        class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3"
                    >
                        <svg
                            class="w-5 h-5 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                            />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            Manage Racks
                        </div>
                        <div class="text-xs text-gray-500">Kategori</div>
                    </div>
                </Link>

                <Link
                    :href="route('files.create')"
                    class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-200"
                >
                    <div
                        class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mr-3"
                    >
                        <svg
                            class="w-5 h-5 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            Upload File
                        </div>
                        <div class="text-xs text-gray-500">Add new file</div>
                    </div>
                </Link>
            </div>

            <!-- User Actions -->
            <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <Link
                    :href="route('files.index')"
                    class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200"
                >
                    <div
                        class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3"
                    >
                        <svg
                            class="w-5 h-5 text-white"
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
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            File Saya
                        </div>
                        <div class="text-xs text-gray-500">Lihat File Terupload</div>
                    </div>
                </Link>

                <Link
                    :href="route('files.create')"
                    class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200"
                >
                    <div
                        class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3"
                    >
                        <svg
                            class="w-5 h-5 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            Upload File
                        </div>
                        <div class="text-xs text-gray-500">Tambahkan File</div>
                    </div>
                </Link>

                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div
                        class="w-10 h-10 bg-gray-400 rounded-lg flex items-center justify-center mr-3"
                    >
                        <svg
                            class="w-5 h-5 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">
                            Ada Keluhan?
                        </div>
                        <div class="text-xs text-gray-500">Kontak Admin/Teknisi</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Racks Management Section (Admin Only) -->
        <div
            v-if="isAdmin && props.racks && props.racks.length > 0"
            class="bg-white rounded-xl shadow-sm border border-pln-gray overflow-hidden mb-8"
        >
            <div
                class="px-6 py-4 border-b border-pln-gray bg-pln-gray flex items-center justify-between"
            >
                <div>
                    <h3 class="text-lg font-semibold text-charcoal">
                        🗂️ Daftar Rak
                    </h3>
                    <p class="text-sm text-gray-600">
                        Manage Rak dan Tambahkan Rak Baru
                    </p>
                </div>
                <Link
                    :href="route('admin.racks.index')"
                    class="inline-flex items-center px-4 py-2 bg-pln-blue text-white text-sm font-medium rounded-lg hover:bg-dark-blue focus:outline-none focus:ring-2 focus:ring-pln-blue focus:ring-offset-2 transition-colors duration-200"
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
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                    Manage Semua Rak
                </Link>
            </div>

            <div class="divide-y divide-pln-gray">
                <div
                    v-for="rack in props.racks"
                    :key="rack.id"
                    class="px-6 py-4 hover:bg-pln-gray transition-colors duration-200"
                >
                    <div class="flex items-center justify-between">
                        <!-- Rack Info -->
                        <div class="flex items-center flex-1">
                            <div
                                class="w-12 h-12 bg-light-blue rounded-lg flex items-center justify-center mr-4"
                            >
                                <svg
                                    class="w-6 h-6 text-pln-blue"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                    />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <h4
                                        class="text-sm font-medium text-charcoal"
                                    >
                                        {{ rack.name }}
                                    </h4>
                                    <span
                                        class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pln-blue text-white"
                                    >
                                        {{ rack.files_count }} files
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ rack.description || "Tanpa Deskripsi" }}
                                </p>

                                <!-- Sub-racks -->
                                <div
                                    v-if="
                                        rack.sub_racks &&
                                        rack.sub_racks.length > 0
                                    "
                                    class="mt-2"
                                >
                                    <div class="flex flex-wrap gap-1">
                                        <span
                                            v-for="subRack in rack.sub_racks.slice(
                                                0,
                                                3
                                            )"
                                            :key="subRack.id"
                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-light-blue text-pln-blue border border-pln-blue"
                                        >
                                            📂 {{ subRack.name }} ({{
                                                subRack.files_count
                                            }})
                                        </span>
                                        <span
                                            v-if="rack.sub_racks.length > 3"
                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600"
                                        >
                                            +{{
                                                rack.sub_racks.length - 3
                                            }}
                                            more
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div
                            class="flex items-center space-x-4 text-sm text-gray-500"
                        >
                            <div class="text-center">
                                <div class="font-medium text-charcoal">
                                    {{ rack.sub_racks_count }}
                                </div>
                                <div class="text-xs">Sub-racks</div>
                            </div>
                            <div class="text-center">
                                <div class="font-medium text-charcoal">
                                    {{ rack.files_count }}
                                </div>
                                <div class="text-xs">Files</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2 ml-4">
                            <Link
                                :href="route('admin.racks.edit', rack.id)"
                                class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium text-gray-700 bg-white rounded hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pln-blue focus:ring-offset-2 transition-colors duration-200"
                            >
                                Edit
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State for Racks -->
            <div
                v-if="isAdmin && (!props.racks || props.racks.length === 0)"
                class="px-6 py-8 text-center"
            >
                <svg
                    class="mx-auto h-12 w-12 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                    />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    No racks created
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Get started by creating your first rack for organizing
                    files.
                </p>
                <div class="mt-6">
                    <Link
                        :href="route('admin.racks.create')"
                        class="inline-flex items-center px-4 py-2 bg-pln-blue text-white text-sm font-medium rounded-lg hover:bg-dark-blue focus:outline-none focus:ring-2 focus:ring-pln-blue focus:ring-offset-2 transition-colors duration-200"
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
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        Create First Rack
                    </Link>
                </div>
            </div>
        </div>

        <!-- Recent Files Section -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
        >
            <div
                class="px-6 py-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h3 class="text-lg font-semibold text-gray-900">
                    {{
                        isAdmin ? "Recent Files (All Users)" : "My Recent Files"
                    }}
                </h3>
                <Link
                    :href="route('files.index')"
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium"
                >
                    Lihat Semua
                </Link>
            </div>

            <div
                v-if="props.recentFiles && props.recentFiles.length > 0"
                class="overflow-x-auto"
            >
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                File
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Nama File
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Kategori
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Ukuran
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Urutan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="(file, index) in props.recentFiles.slice(
                                0,
                                10
                            )"
                            :key="file.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-gray-600"
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
                                    </div>
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ file.title }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{
                                                file.uploader?.name || "Unknown"
                                            }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ file.rack?.name || "No Rack" }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ file.formatted_size }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{
                                    new Date(
                                        file.created_at
                                    ).toLocaleDateString()
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div v-else class="px-6 py-12 text-center">
                <svg
                    class="mx-auto h-12 w-12 text-gray-400"
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
                <h3 class="mt-2 text-sm font-medium text-gray-900">No Files</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{
                        isAdmin
                            ? "No files have been uploaded yet."
                            : "You haven't uploaded any files yet."
                    }}
                </p>
                <div class="mt-6">
                    <Link
                        :href="route('files.create')"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pln-blue hover:bg-dark-blue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pln-blue"
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
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        {{
                            isAdmin
                                ? "Upload First File"
                                : "Upload Your First File"
                        }}
                    </Link>
                </div>
            </div>
        </div>
    </component>
</template>
