<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
const isAdmin = computed(() => user.value.role === "admin");

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Profile update form
const profileForm = useForm({
    name: user.value.name,
    email: user.value.email,
    instansi: user.value.instansi,
    no_telp: user.value.no_telp || "",
});

// Password update form
const passwordForm = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updateProfile = () => {
    profileForm.patch(route("profile.update"), {
        preserveScroll: true,
        onSuccess: () => {
            // Profile updated successfully
        },
    });
};

const updatePassword = () => {
    passwordForm.patch(route("profile.password.update"), {
        preserveScroll: true,
        onSuccess: () => {
            passwordForm.reset();
        },
        onError: () => {
            passwordForm.reset("password", "password_confirmation");
        },
    });
};

// Get appropriate layout component
const LayoutComponent = computed(() =>
    isAdmin.value ? AdminLayout : UserLayout
);
</script>

<template>
    <Head title="Edit Profile - SIPUS" />

    <component :is="LayoutComponent">
        <template #header> Edit Profile </template>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Profile Information -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
            >
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">
                        👤 Informasi Profil
                    </h3>
                    <p class="text-sm text-gray-600">
                        Update informasi akun dan alamat email Anda.
                    </p>
                </div>

                <form @submit.prevent="updateProfile" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Nama Lengkap *
                            </label>
                            <input
                                v-model="profileForm.name"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pln-blue focus:border-transparent"
                                placeholder="Masukkan nama lengkap"
                                required
                            />
                            <div
                                v-if="profileForm.errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ profileForm.errors.name }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Email *
                            </label>
                            <input
                                v-model="profileForm.email"
                                type="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pln-blue focus:border-transparent"
                                placeholder="Masukkan email"
                                required
                            />
                            <div
                                v-if="profileForm.errors.email"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ profileForm.errors.email }}
                            </div>
                        </div>

                        <!-- Instansi -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Instansi/Unit Kerja *
                            </label>
                            <input
                                v-model="profileForm.instansi"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pln-blue focus:border-transparent"
                                placeholder="Masukkan instansi/unit kerja"
                                required
                            />
                            <div
                                v-if="profileForm.errors.instansi"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ profileForm.errors.instansi }}
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                No. Telepon
                            </label>
                            <input
                                v-model="profileForm.no_telp"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pln-blue focus:border-transparent"
                                placeholder="Masukkan nomor telepon (opsional)"
                            />
                            <div
                                v-if="profileForm.errors.no_telp"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ profileForm.errors.no_telp }}
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            :disabled="profileForm.processing"
                            class="px-6 py-2 bg-pln-blue text-white rounded-lg hover:bg-dark-blue focus:outline-none focus:ring-2 focus:ring-pln-blue disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                        >
                            <span
                                v-if="profileForm.processing"
                                class="flex items-center"
                            >
                                <svg
                                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                Updating...
                            </span>
                            <span v-else>Update Profile</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
            >
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">
                        🔒 Ubah Password
                    </h3>
                    <p class="text-sm text-gray-600">
                        Pastikan akun Anda menggunakan password yang kuat untuk
                        keamanan.
                    </p>
                </div>

                <form @submit.prevent="updatePassword" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Current Password -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Password Saat Ini *
                            </label>
                            <input
                                v-model="passwordForm.current_password"
                                type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pln-blue focus:border-transparent"
                                placeholder="Masukkan password saat ini"
                                required
                            />
                            <div
                                v-if="passwordForm.errors.current_password"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ passwordForm.errors.current_password }}
                            </div>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Password Baru *
                            </label>
                            <input
                                v-model="passwordForm.password"
                                type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pln-blue focus:border-transparent"
                                placeholder="Masukkan password baru"
                                required
                            />
                            <div
                                v-if="passwordForm.errors.password"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ passwordForm.errors.password }}
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Konfirmasi Password *
                            </label>
                            <input
                                v-model="passwordForm.password_confirmation"
                                type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pln-blue focus:border-transparent"
                                placeholder="Konfirmasi password baru"
                                required
                            />
                            <div
                                v-if="passwordForm.errors.password_confirmation"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ passwordForm.errors.password_confirmation }}
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            :disabled="passwordForm.processing"
                            class="px-6 py-2 bg-pln-blue text-white rounded-lg hover:bg-dark-blue focus:outline-none focus:ring-2 focus:ring-pln-blue disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                        >
                            <span
                                v-if="passwordForm.processing"
                                class="flex items-center"
                            >
                                <svg
                                    class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                Updating...
                            </span>
                            <span v-else>Update Password</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Information -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
            >
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">
                        ℹ️ Informasi Akun
                    </h3>
                    <p class="text-sm text-gray-600">
                        Detail tambahan tentang akun Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Role
                        </label>
                        <div
                            class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg"
                        >
                            <span
                                :class="[
                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                    user.role === 'admin'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-blue-100 text-blue-800',
                                ]"
                            >
                                {{
                                    user.role === "admin"
                                        ? "Administrator"
                                        : "User"
                                }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Status
                        </label>
                        <div
                            class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg"
                        >
                            <span
                                :class="[
                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                    user.is_approved
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-yellow-100 text-yellow-800',
                                ]"
                            >
                                {{
                                    user.is_approved
                                        ? "Disetujui"
                                        : "Menunggu Persetujuan"
                                }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>
