<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import InputSearch from '@/Components/InputSearch.vue';
import { executeWithDelay, useToggle } from '@/helpers';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{ suggestions?: string[] }>();

const isHover = ref(false);
const isLoading = ref(false);
const [isLoadingSelected, setIsLoadingSelected] = useToggle(false);

function fetchWithDelay(query: string) {
    isLoading.value = true;
    executeWithDelay(() => {
        router.reload({
            method: 'post',
            data: { query },
            onFinish: () => (isLoading.value = false),
        });
    });
}

const selectSuggestion = (word: string) => {
    setIsLoadingSelected();
    router.get(route('word', { word }));
};
</script>

<template>
    <Head>
        <title>Inicio</title>
        <meta
            name="description"
            content="No DicioSimples, pesquise palavras e encontre definições claras e objetivas de forma rápida e prática."
        />
    </Head>
    <div
        class="mx-auto mt-[8%] flex flex-col items-center p-4 sm:w-10/12 lg:w-8/12"
    >
        <div
            class="mb-4 flex w-1/2 items-baseline justify-center space-x-2 pb-4"
        >
            <ApplicationLogo width="45%" />
            <ApplicationLogo width="80%" />
            <ApplicationLogo width="45%" />
        </div>
        <InputSearch
            :submit="() => suggestions && selectSuggestion(suggestions[0])"
            :input-search="fetchWithDelay"
            :is-loading="isLoadingSelected"
        >
            <ul class="divide-y divide-gray-200">
                <li v-if="isLoading" class="px-4 py-2">Carregando...</li>
                <li v-else-if="!suggestions?.length" class="px-4 py-2">
                    Nenhuma sugestão encontrada
                </li>
                <li
                    v-else
                    v-for="(suggestion, index) in suggestions"
                    :key="suggestion"
                    @click="selectSuggestion(suggestion)"
                    @mouseenter="isHover = true"
                    @mouseleave="isHover = false"
                    :class="[
                        isHover ? 'hover:bg-gray-100' : !index && 'bg-gray-100',
                    ]"
                    class="cursor-pointer px-4 py-2 sm:px-6"
                >
                    {{ suggestion }}
                </li>
            </ul>
        </InputSearch>
    </div>
</template>
