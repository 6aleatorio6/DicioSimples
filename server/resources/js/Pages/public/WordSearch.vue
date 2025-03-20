<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import InputSearchWithSuggestions from '@/Components/InputSearchWithSuggestions.vue';
import { executeWithDelay } from '@/helpers';
import { Head, router } from '@inertiajs/vue3';

const DELAY = 260;

defineProps<{ suggestions?: string[] }>();

function fetchWithDelay(query: string, onF: () => void) {
    executeWithDelay(() => {
        router.reload({
            method: 'post',
            data: { query },
            only: ['suggestions'],
            onFinish: onF,
        });
    }, DELAY);
}

function getWord(query: string) {
    router.get(route('word', query.toLowerCase()));
}
</script>

<template>
    <div
        class="mx-auto mt-[25%] flex flex-col items-center p-4 sm:mt-[10%] sm:w-10/12 lg:w-8/12"
    >
        <Head>
            <title>Inicio</title>
            <meta
                name="description"
                content="Pesquise palavras e obtenha explicações claras e objetivas de forma rápida e prática, com antônimos, sinônimos e descrições detalhadas dos diversos significados."
            />
        </Head>
        <div
            class="mb-4 flex w-1/3 items-baseline justify-center space-x-2 sm:pb-4"
        >
            <ApplicationLogo width="45%" />
            <ApplicationLogo width="80%" />
            <ApplicationLogo width="45%" />
        </div>
        <InputSearchWithSuggestions
            :suggestions="suggestions"
            @fetch-suggestions="fetchWithDelay"
            @selected-word="getWord"
        />
    </div>
</template>
