<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    rack: Object,
    subRack: Object,
    files: Object,
});

// Format file size
const formatFileSize = (bytes) => {
    if (bytes >= 1073741824) {
        return (bytes / 1073741824).toFixed(2) + " GB";
    } else if (bytes >= 1048576) {
        return (bytes / 1048576).toFixed(2) + " MB";
    } else if (bytes >= 1024) {
        return (bytes / 1024).toFixed(2) + " KB";
    } else {
        return bytes + " bytes";
    }
};

// Download file
const downloadFile = (file) => {
    window.open(route("files.download", file.id), "_blank");
};

// Format date
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
};
</script>

<template>
    <Head :title="`${subRack?.name || 'Sub-Rack'} - Files - SIPUS`" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <Link
                        :href="route('admin.racks.index')"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                    </Link>
                    <Link
                        :href="route('admin.racks.show', rack.id)"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        📁 {{ rack?.name }}
                    </Link>
                    <span class="text-gray-500">/</span>
                    <h1 class="text-2xl font-bold text-gray-900">
                        📂 {{ subRack?.name }}
                    </h1>
                </div>
            </div>
        </template>

        <!-- Sub-Rack Information -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6"
        >
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">
                        Nama Sub-Rak
                    </h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ subRack?.name }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Rak Induk</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ rack?.name }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">
                        Total Files
                    </h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ files?.total || 0 }} Files
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">
                        Dibuat Tanggal
                    </h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ formatDate(subRack?.created_at) }}
                    </p>
                </div>
            </div>
            <div v-if="subRack?.description" class="mt-4">
                <h3 class="text-sm font-medium text-gray-500">Deskripsi</h3>
                <p class="mt-1 text-gray-700">{{ subRack.description }}</p>
            </div>
        </div>

        <!-- Files List -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
        >
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    📄 Daftar Files
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    Files yang tersimpan dalam sub-rak "{{ subRack?.name }}"
                </p>
            </div>

            <div v-if="files && files.data && files.data.length > 0">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div
                        class="grid gap-4 text-xs font-medium text-gray-500 uppercase tracking-wider grid-cols-12"
                    >
                        <div class="col-span-5">Info Berkas</div>
                        <div class="col-span-2">Ukuran</div>
                        <div class="col-span-2">Diupload Oleh</div>
                        <div class="col-span-2">Tanggal</div>
                        <div class="col-span-1">Actions</div>
                    </div>
                </div>

                <!-- File List -->
                <div class="divide-y divide-gray-200">
                    <div
                        v-for="file in files.data"
                        :key="file.id"
                        class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200"
                    >
                        <div class="grid gap-4 items-center grid-cols-12">
                            <!-- File Info -->
                            <div class="col-span-5">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3"
                                    >
                                        <svg
                                            class="w-5 h-5 text-pln-blue"
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
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ file.title }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{
                                                file.description ||
                                                "Tanpa Deskripsi"
                                            }}
                                        </div>
                                        <!-- Tags display -->
                                        <div
                                            v-if="
                                                file.tags &&
                                                file.tags.length > 0
                                            "
                                            class="mt-1 flex flex-wrap gap-1"
                                        >
                                            <span
                                                v-for="tag in file.tags.slice(
                                                    0,
                                                    3
                                                )"
                                                :key="tag.id"
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700"
                                            >
                                                #{{ tag.name }}
                                            </span>
                                            <span
                                                v-if="file.tags.length > 3"
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500"
                                            >
                                                +{{ file.tags.length - 3 }} more
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Size -->
                            <div class="col-span-2">
                                <div class="text-sm text-gray-900">
                                    {{
                                        file.formatted_size ||
                                        formatFileSize(file.size)
                                    }}
                                </div>
                            </div>

                            <!-- Uploaded By -->
                            <div class="col-span-2">
                                <div class="text-sm text-gray-900">
                                    {{ file.uploader?.name || "Unknown" }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ file.uploader?.instansi || "" }}
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="col-span-2">
                                <div class="text-sm text-gray-500">
                                    {{
                                        new Date(
                                            file.created_at
                                        ).toLocaleDateString()
                                    }}
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="col-span-1">
                                <div class="flex items-center space-x-2">
                                    <!-- View Details Button -->
                                    <Link
                                        :href="route('files.show', file.id)"
                                        class="text-blue-500 hover:text-blue-700 p-1 rounded transition-colors duration-200"
                                        title="📄 View Details"
                                    >
                                        <svg
                                            class="w-4 h-4"
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
                                    </Link>

                                    <!-- Download Button -->
                                    <button
                                        @click="downloadFile(file)"
                                        class="text-pln-blue hover:text-dark-blue p-1 rounded transition-colors duration-200"
                                        title="📥 Download"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div
                    v-if="files.links"
                    class="px-6 py-4 border-t border-gray-200 bg-gray-50"
                >
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ files.from }} to {{ files.to }} of
                            {{ files.total }} results
                        </div>
                        <div class="flex space-x-1">
                            <template
                                v-for="link in files.links"
                                :key="link.label"
                            >
                                <Link
                                    v-if="link.url"
                                    :href="link.url"
                                    :class="[
                                        'px-3 py-2 text-sm rounded-md',
                                        link.active
                                            ? 'bg-pln-blue text-white'
                                            : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100',
                                    ]"
                                    v-html="link.label"
                                />
                                <span
                                    v-else
                                    :class="[
                                        'px-3 py-2 text-sm rounded-md',
                                        'text-gray-400 cursor-not-allowed',
                                    ]"
                                    v-html="link.label"
                                />
                            </template>
                        </div>
                    </div>
                </div>
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
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    Belum ada files
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Belum ada files yang diupload ke sub-rak "{{
                        subRack?.name
                    }}".
                </p>
                <div class="mt-6">
                    <Link
                        :href="route('files.create')"
                        class="inline-flex items-center px-4 py-2 bg-pln-blue text-white text-sm font-medium rounded-lg hover:bg-dark-blue focus:outline-none focus:ring-2 focus:ring-pln-blue focus:ring-offset-2"
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
                        Upload File
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
