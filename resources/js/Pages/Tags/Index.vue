<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { ref, reactive, computed } from "vue";

const page = usePage();

defineProps({
    tags: Object,
    filters: Object,
    canManage: Boolean,
});

// Check if current user is admin
const isAdmin = computed(() => page.props.auth.user.role === "admin");

const searchQuery = ref("");
const showDeleteModal = ref(false);
const tagToDelete = ref(null);

const filterForm = reactive({
    search: "",
});

const searchTags = () => {
    router.get(
        route("tags.index"),
        { search: searchQuery.value },
        { preserveState: true }
    );
};

const resetFilters = () => {
    searchQuery.value = "";
    router.get(route("tags.index"));
};

const deleteTag = (tag) => {
    tagToDelete.value = tag;
    showDeleteModal.value = true;
};

const confirmDelete = () => {
    if (tagToDelete.value) {
        router.delete(route("tags.destroy", tagToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false;
                tagToDelete.value = null;
            },
            onError: () => {
                // Keep modal open on error
            },
        });
    }
};

const cancelDelete = () => {
    showDeleteModal.value = false;
    tagToDelete.value = null;
};

// Get appropriate layout component
const LayoutComponent = computed(() =>
    isAdmin.value ? AdminLayout : UserLayout
);
</script>

<template>
    <Head title="Tags Management - SIPUS" />

    <LayoutComponent>
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">
                                Tags Management
                            </h1>
                            <p class="mt-2 text-gray-600">
                                Kelola semua tag yang digunakan untuk
                                mengorganisir file
                            </p>
                        </div>

                        <!-- Add Tag Button - Only for admin -->
                        <div v-if="canManage">
                            <Link
                                :href="route('tags.create')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
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
                                    ></path>
                                </svg>
                                Tambah Tag
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6"
                >
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label
                                for="search"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Cari Tag
                            </label>
                            <div class="relative">
                                <input
                                    id="search"
                                    v-model="searchQuery"
                                    type="text"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Masukkan nama tag..."
                                    @keyup.enter="searchTags"
                                />
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                                >
                                    <svg
                                        class="h-5 w-5 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-end gap-3">
                            <button
                                @click="searchTags"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                            >
                                Cari
                            </button>
                            <button
                                @click="resetFilters"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors"
                            >
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tags List -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden"
                >
                    <div v-if="tags.data.length > 0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Nama Tag
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Jumlah File
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Slug
                                        </th>
                                        <th
                                            v-if="canManage"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr
                                        v-for="tag in tags.data"
                                        :key="tag.id"
                                        class="hover:bg-gray-50"
                                    >
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center"
                                                >
                                                    <svg
                                                        class="w-4 h-4 text-blue-600"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                                        ></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <Link
                                                        :href="
                                                            route(
                                                                'tags.show',
                                                                tag.id
                                                            )
                                                        "
                                                        class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors"
                                                    >
                                                        {{ tag.name }}
                                                    </Link>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                        >
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                            >
                                                {{
                                                    tag.files_count || 0
                                                }}
                                                file(s)
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                        >
                                            {{ tag.slug }}
                                        </td>
                                        <td
                                            v-if="canManage"
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                        >
                                            <div
                                                class="flex items-center justify-end space-x-2"
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'tags.edit',
                                                            tag.id
                                                        )
                                                    "
                                                    class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                                    title="Edit Tag"
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
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                        ></path>
                                                    </svg>
                                                </Link>
                                                <button
                                                    @click="deleteTag(tag)"
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Delete Tag"
                                                    :disabled="
                                                        tag.files_count > 0
                                                    "
                                                    :class="{
                                                        'opacity-50 cursor-not-allowed':
                                                            tag.files_count > 0,
                                                    }"
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
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                        ></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div
                            v-if="tags.last_page > 1"
                            class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6"
                        >
                            <div class="flex items-center justify-between">
                                <div
                                    class="flex-1 flex justify-between sm:hidden"
                                >
                                    <Link
                                        v-if="tags.prev_page_url"
                                        :href="tags.prev_page_url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Previous
                                    </Link>
                                    <Link
                                        v-if="tags.next_page_url"
                                        :href="tags.next_page_url"
                                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Next
                                    </Link>
                                </div>
                                <div
                                    class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                                >
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Showing
                                            <span class="font-medium">{{
                                                tags.from
                                            }}</span>
                                            to
                                            <span class="font-medium">{{
                                                tags.to
                                            }}</span>
                                            of
                                            <span class="font-medium">{{
                                                tags.total
                                            }}</span>
                                            results
                                        </p>
                                    </div>
                                    <div>
                                        <nav
                                            class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                            aria-label="Pagination"
                                        >
                                            <!-- Pagination links would go here -->
                                            <Link
                                                v-if="tags.prev_page_url"
                                                :href="tags.prev_page_url"
                                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                            >
                                                Previous
                                            </Link>
                                            <Link
                                                v-if="tags.next_page_url"
                                                :href="tags.next_page_url"
                                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                                            >
                                                Next
                                            </Link>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="text-center py-12">
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
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                            ></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            Tidak ada tag
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Mulai dengan membuat tag pertama.
                        </p>
                        <div v-if="canManage" class="mt-6">
                            <Link
                                :href="route('tags.create')"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <svg
                                    class="-ml-1 mr-2 h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4v16m8-8H4"
                                    ></path>
                                </svg>
                                Tambah Tag
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
            @click="cancelDelete"
        >
            <div
                class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
                @click.stop
            >
                <div class="mt-3">
                    <div
                        class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full"
                    >
                        <svg
                            class="w-6 h-6 text-red-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                            ></path>
                        </svg>
                    </div>
                    <h3
                        class="text-lg font-medium text-gray-900 mt-4 text-center"
                    >
                        Hapus Tag
                    </h3>
                    <p class="text-sm text-gray-500 mt-2 text-center">
                        Apakah Anda yakin ingin menghapus tag "<strong>{{
                            tagToDelete?.name
                        }}</strong
                        >"? Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <div class="flex justify-center gap-3 mt-6">
                        <button
                            @click="cancelDelete"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Batal
                        </button>
                        <button
                            @click="confirmDelete"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                        >
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </LayoutComponent>
</template>
