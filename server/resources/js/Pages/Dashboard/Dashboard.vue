<script setup lang="ts">
import { capWord } from '@/helpers';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TableWordResponse, Word } from '@/types/words';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import DataTable from './Partials/DataTable.vue';
import DeleteWord from './Partials/DeleteWord.vue';
import WordShow from './Partials/WordShow.vue';

const props = defineProps<{ tableWords: TableWordResponse }>();

const showWord = ref<null | Word>(null);
const deleteWord = ref<null | Word>(null);
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="mx-auto max-w-7xl pb-16 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="">
                    <div
                        class="flex justify-between overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg"
                    >
                        <p class="my-auto text-3xl font-bold">
                            Olá, {{ capWord($page.props.auth.user.name) }}!
                        </p>
                    </div>
                </div>
            </div>

            <DataTable
                :tableData="props.tableWords"
                @show-word="(w) => (showWord = w)"
                @delete-word="(w) => (deleteWord = w)"
            />
            <WordShow :word-content="showWord" @close="showWord = null" />
            <DeleteWord
                :word-content="deleteWord"
                @close="(deleteWord = null) || router.reload()"
            />
        </div>
    </AuthenticatedLayout>
</template>
