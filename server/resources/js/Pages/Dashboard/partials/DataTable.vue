<script setup lang="ts">
import { TableWordResponse } from '@/types/Dashboard';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const { tableData } = defineProps<{ tableData: TableWordResponse }>();
const search = ref();

function reloadPage(url: string) {
    router.get(url, undefined, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
}

const handleSearch = function () {
    if (handleSearch.timeout) clearTimeout(handleSearch.timeout);

    handleSearch.timeout = setTimeout(
        () => reloadPage(route('dashboard', { q: search.value })),
        250,
    );
} as any;
</script>

<template>
    <div class="mb-3 flex w-full items-center justify-between pl-3">
        <div>
            <h3 class="text-lg font-semibold text-slate-800">
                Palavras cadastradas
            </h3>
            <p class="text-slate-500">Com sua descrição e contagem de views</p>
        </div>
        <div class="ml-3">
            <div class="relative flex w-full min-w-[200px] max-w-sm">
                <button
                    class="top-1 my-auto flex h-9 w-9 items-center rounded px-2"
                    type="button"
                    @click="(search = '') || reloadPage(route('dashboard'))"
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
                        v-model="search"
                        @input="handleSearch"
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
        <table class="w-full min-w-max table-auto text-left">
            <thead>
                <tr>
                    <th class="border-b border-slate-200 bg-slate-50 p-4">
                        <p
                            class="text-sm font-normal leading-none text-slate-500"
                        >
                            Palavra
                        </p>
                    </th>

                    <th class="border-b border-slate-200 bg-slate-50 p-4">
                        <p
                            class="text-sm font-normal leading-none text-slate-500"
                        >
                            Descrição
                        </p>
                    </th>

                    <th class="border-b border-slate-200 bg-slate-50 p-4">
                        <p
                            class="text-sm font-normal leading-none text-slate-500"
                        >
                            Visualizações
                        </p>
                    </th>

                    <th class="border-b border-slate-200 bg-slate-50 p-4">
                        <p
                            class="text-sm font-normal leading-none text-slate-500"
                        >
                            Ações
                        </p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="page in tableData.data"
                    :key="page.id"
                    class="border-b border-slate-200 hover:bg-slate-50"
                >
                    <td class="p-4 py-5">
                        <p class="block text-sm font-semibold text-slate-800">
                            {{ page.name }}
                        </p>
                    </td>
                    <td class="p-4 py-5">
                        <p class="text-sm text-slate-500">
                            {{ page.summary || 'Sem explicação' }}
                        </p>
                    </td>
                    <td class="p-4 py-5">
                        <p class="text-sm text-slate-500">{{ page.views }}</p>
                    </td>
                    <td class="p-4 py-5">
                        <p class="text-sm text-slate-500">X | X | X</p>
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
                    @click="() => reloadPage(`${page.url!}&q=${search || ''}`)"
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
