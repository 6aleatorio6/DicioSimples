<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import InputSearch from '@/Components/InputSearch.vue';
import { executeWithDelay, useToggle } from '@/helpers';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const DELAY = 260;

const props = defineProps<{ suggestions?: string[] }>();

const isLoading = ref(false);
const suggestionSelected = ref<string | undefined>();
const [isLoadingSelected, setIsLoadingSelected] = useToggle(false);

function fetchWithDelay(query: string) {
    isLoading.value = true;
    executeWithDelay(() => {
        router.reload({
            method: 'post',
            data: { query },
            only: ['suggestions'],
            onFinish: () => (isLoading.value = false),
        });
    }, DELAY);
}

watch(
    () => props.suggestions,
    () => (suggestionSelected.value = props.suggestions?.[0]),
);

const selectSuggestion = () => {
    if (!suggestionSelected.value) return;
    setIsLoadingSelected();
    router.get(route('word', { word: suggestionSelected.value }));
};

const moveSelected = (distance: number) => {
    if (!props.suggestions?.length) return;
    const index = props.suggestions.indexOf(suggestionSelected.value!);

    let newIndex = index + distance;
    if (newIndex < 0) newIndex = props.suggestions.length - 1;
    if (newIndex >= props.suggestions.length) newIndex = 0;

    suggestionSelected.value = props.suggestions[newIndex];
};
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
        <InputSearch
            :is-loading="isLoadingSelected"
            @input="fetchWithDelay"
            @down="moveSelected(1)"
            @up="moveSelected(-1)"
            @enter="selectSuggestion"
        >
            <ul
                class="divide-y divide-gray-200"
                @mouseleave="suggestionSelected = props.suggestions?.[0]"
            >
                <li v-if="isLoading" class="px-4 py-2">Carregando...</li>
                <li v-else-if="!suggestions?.length" class="px-4 py-2">
                    Nenhuma sugestão encontrada
                </li>
                <li
                    v-else
                    v-for="suggestion in suggestions"
                    :key="suggestion"
                    @click="selectSuggestion"
                    @mouseenter="suggestionSelected = suggestion"
                    :class="{ 'bg-gray-100': suggestionSelected == suggestion }"
                    class="cursor-pointer px-4 py-2 sm:px-6"
                >
                    {{ suggestion }}
                </li>
            </ul>
        </InputSearch>
    </div>
</template>
