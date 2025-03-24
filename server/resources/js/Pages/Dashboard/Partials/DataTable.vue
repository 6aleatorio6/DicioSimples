<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { executeWithDelay } from '@/helpers';
import { TableWordResponse, Word } from '@/types/words';
import { router } from '@inertiajs/vue3';
import { nextTick, ref, watch } from 'vue';
import { useRoute } from '../../../../../vendor/tightenco/ziggy/src/js';

const emit = defineEmits<{ showWord: [word: Word] }>();

const { tableData } = defineProps<{ tableData: TableWordResponse }>();

const route = useRoute();

const query = ref((route().queryParams['query'] as string) || '');

function navPagination(url: string) {
    const params = new URL(url);
    const page = params.searchParams.get('page');
    if (page) router.reload({ data: { page, query: query.value } });
}

const handleSearch = function () {
    router.reload({ data: { query: query.value } });
};

const resetSearch = function () {
    query.value = '';
    handleSearch();
};

const tableRef = ref<HTMLTableElement | null>(null);
watch(
    () => tableData.data,
    () => {
        nextTick(() =>
            tableRef.value?.scrollIntoView({
                behavior: 'smooth',
                block: 'center',
            }),
        );
    },
);
</script>

<template>
    <div class="mb-3 flex w-full items-center justify-between pl-3">
        <div class="space-y-1">
            <h3 class="text-lg font-semibold text-slate-800">
                Palavras Geradas
            </h3>
            <p class="text-slate-500">
                Essas palavras foram solicitadas pelo usuário e criadas pelo
                Gemini AI.
            </p>
        </div>

        <div class="ml-3">
            <div class="relative flex w-full min-w-[200px] max-w-sm">
                <button
                    class="top-1 my-auto flex h-9 w-9 items-center rounded px-2"
                    type="button"
                    @click="resetSearch"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="3"
                        stroke="currentColor"
                        class="h-8 w-8 text-slate-600"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
                <div class="relative">
                    <input
                        v-model="query"
                        @input="executeWithDelay(handleSearch, 200)"
                        class="ease h-10 w-full rounded border border-slate-200 bg-transparent bg-white py-2 pl-3 pr-11 text-sm text-slate-700 shadow-sm transition duration-200 placeholder:text-slate-400 hover:border-slate-400 focus:border-slate-400 focus:shadow-md focus:outline-none"
                        placeholder="Pesquise a palavra..."
                    />
                    <button
                        class="absolute right-1 top-1 my-auto flex h-8 w-8 items-center rounded bg-white px-2"
                        type="button"
                        @click="handleSearch"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="3"
                            stroke="currentColor"
                            class="h-8 w-8 text-slate-600"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div
        class="relative flex h-full w-full flex-col rounded-lg bg-white bg-clip-border text-gray-700 shadow-md"
    >
        <table class="w-full min-w-max table-auto text-left" ref="tableRef">
            <thead>
                <tr>
                    <th
                        v-for="header in [
                            'Palavra',
                            'Classe',
                            'Contextos',
                            'Visualizações',
                            'Ações',
                        ]"
                        :key="header"
                        class="border-b border-slate-200 bg-slate-50 p-4"
                    >
                        <p
                            class="text-sm font-normal leading-none text-slate-500"
                        >
                            {{ header }}
                        </p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="wordD in tableData.data"
                    :key="wordD.id"
                    class="border-b border-slate-200 hover:bg-slate-50"
                >
                    <td class="p-4 py-5">
                        <p
                            class="block font-semibold capitalize text-slate-800"
                        >
                            {{ wordD.word }}
                        </p>
                    </td>
                    <td class="p-4 py-5">
                        <p class="text-sm text-slate-500">
                            {{ wordD.partOfSpeech }}
                        </p>
                    </td>
                    <td class="p-4 py-5">
                        <p class="text-sm text-slate-500">
                            {{ wordD.meanings.map((m) => m.title).join(', ') }}
                        </p>
                    </td>
                    <td class="p-4 py-5">
                        <p class="text-sm text-slate-500">{{ wordD.views }}</p>
                    </td>

                    <td class="flex space-x-2 px-4 py-5">
                        <PrimaryButton
                            class="flex h-6 w-1 justify-center !p-3 text-sm"
                            @click="emit('showWord', wordD)"
                        >
                            ?
                        </PrimaryButton>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center justify-between px-4 py-3">
            <div class="text-sm text-slate-500">
                Mostrando <b>{{ tableData.from }}</b> a
                <b>{{ tableData.to }}</b> de <b>{{ tableData.total }}</b>
            </div>
            <div class="flex space-x-1">
                <button
                    v-for="page in tableData.links"
                    :key="page.label"
                    :disabled="!page.url"
                    @click="() => page.url && navPagination(page.url)"
                    :class="[
                        'ease min-h-9 min-w-9 rounded border px-3 py-1 text-sm font-normal transition duration-200',
                        page.active
                            ? 'border-slate-800 bg-slate-800 text-white hover:border-slate-600 hover:bg-slate-600'
                            : 'border-slate-200 bg-white text-slate-500 hover:border-slate-400 hover:bg-slate-50',
                    ]"
                    v-html="page.label"
                />
            </div>
        </div>
    </div>
</template>
