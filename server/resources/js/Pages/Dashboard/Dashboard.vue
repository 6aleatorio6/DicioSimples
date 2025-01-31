<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TableWordResponse } from '@/types/Dashboard';
import { Head } from '@inertiajs/vue3';
import DataTable from './partials/DataTable.vue';
import ImportWordsForm from './partials/ImportWordsForm.vue';

const props = defineProps<{ tableWords: TableWordResponse }>();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="">
                    <div
                        class="flex justify-between overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg"
                    >
                        <p class="my-auto text-4xl font-bold">Olá Criatura!</p>

                        <ImportWordsForm />
                    </div>
                </div>
            </div>

            <DataTable :tableData="props.tableWords" />
        </div>
    </AuthenticatedLayout>
</template>
