<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    rack: Object,
    subRacks: {
        type: Array,
        default: () => [],
    },
});

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
    <Head :title="`${rack?.name || 'Rack'} - Sub-Racks - SIPUS`" />

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
                    <h1 class="text-2xl font-bold text-gray-900">
                        📁 {{ rack?.name }}
                    </h1>
                </div>
                <Link
                    :href="route('admin.racks.sub-racks.create', rack.id)"
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
                    Tambah Sub-Rak
                </Link>
            </div>
        </template>

        <!-- Rack Information -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6"
        >
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Nama Rak</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ rack?.name }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">
                        Jumlah Sub-Rak
                    </h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ subRacks?.length || 0 }} Sub-Rak
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">
                        Dibuat Tanggal
                    </h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ formatDate(rack?.created_at) }}
                    </p>
                </div>
            </div>
            <div v-if="rack?.description" class="mt-4">
                <h3 class="text-sm font-medium text-gray-500">Deskripsi</h3>
                <p class="mt-1 text-gray-700">{{ rack.description }}</p>
            </div>
        </div>

        <!-- Sub-Racks List -->
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden"
        >
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    📂 Daftar Sub-Rak
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    Klik sub-rak untuk melihat file yang ada di dalamnya
                </p>
            </div>

            <div v-if="subRacks && subRacks.length > 0">
                <!-- Sub-Racks Grid -->
                <div class="p-6">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <div
                            v-for="subRack in subRacks"
                            :key="subRack.id"
                            class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:bg-gray-100 hover:border-gray-300 transition-all duration-200 cursor-pointer group"
                            @click="
                                $inertia.visit(
                                    route('admin.racks.sub-racks.show', [
                                        rack.id,
                                        subRack.id,
                                    ])
                                )
                            "
                        >
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200"
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
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4
                                                class="text-sm font-medium text-gray-900 group-hover:text-pln-blue transition-colors duration-200"
                                            >
                                                {{ subRack.name }}
                                            </h4>
                                            <p class="text-xs text-gray-500">
                                                {{
                                                    subRack.files_count || 0
                                                }}
                                                file(s)
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        v-if="subRack.description"
                                        class="mt-2 text-xs text-gray-600"
                                    >
                                        {{ subRack.description }}
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        Dibuat:
                                        {{ formatDate(subRack.created_at) }}
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <svg
                                        class="w-4 h-4 text-gray-400 group-hover:text-pln-blue transition-colors duration-200"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </div>
                            </div>
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
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                    />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    Belum ada Sub-Rak
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Mulai dengan membuat sub-rak pertama untuk mengorganisir
                    file.
                </p>
                <div class="mt-6">
                    <Link
                        :href="route('admin.racks.sub-racks.create', rack.id)"
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
                        Tambah Sub-Rak Pertama
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
