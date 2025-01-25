<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ImportWordsForm from './Partials/ImportWordsForm.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="flex justify-between overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg"
                >
                    <p class="my-auto text-4xl font-bold">Olá Criatura!</p>

                    <ImportWordsForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
