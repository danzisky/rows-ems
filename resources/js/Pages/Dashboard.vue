<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    employeesCount: {
        type: Number,
        required: true,
    },
    certificationsCount: {
        type: Number,
        required: true,
    },
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 max-lg:px-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <v-row class="p-6">
                        <v-col cols="12" md="6">
                            <v-card-title>Employees</v-card-title>
                            <v-list-item>
                                <v-list-item-title>
                                    <div class="text-h1 font-mono">{{ employeesCount }}</div>
                                </v-list-item-title>
                            </v-list-item>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-card-title>Certifications</v-card-title>
                            <v-list-item>
                                <v-list-item-title>
                                    <div class="text-h1 font-mono">{{ certificationsCount }}</div>
                                </v-list-item-title>
                            </v-list-item>
                        </v-col>
                        <v-col cols="12">
                            <div class="grid lg:grid-cols-2 gap-6">
                                <v-btn
                                    class="w-max"
                                    color="primary"
                                    @click="router.get(route('employees.index'))"
                                >
                                    View Employees
                                </v-btn>
                                <v-btn
                                    class="w-max"
                                    color="primary"
                                    @click="router.get(route('certifications.index'))"
                                >
                                    View Certifications
                                </v-btn>
                            </div>
                        </v-col>
                    </v-row>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
