<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    suggestions?: string[];
    hasSuggestions?: boolean;
}>();

const query = ref('');
const isLoading = ref(false);

const fetchSuggestionsWithDelay = function () {
    isLoading.value = true;
    const fetch = () => {
        router.reload({
            method: 'post',
            data: { query: query.value },
            onFinish: () => (isLoading.value = false),
        });
    };

    // cancela a requisição anterior e inicia uma nova
    const self = fetchSuggestionsWithDelay as any;
    if (self.timeout) clearTimeout(self.timeout);
    self.timeout = setTimeout(fetch, 250);
};

const selectSuggestion = (word: string) => {};
</script>

<template>
    <div
        class="mx-auto mt-[5%] flex flex-col items-center p-4 sm:w-8/12 lg:w-5/12"
    >
        <Head title="Inicio" />
        <div
            class="mb-4 flex w-1/2 items-baseline justify-center space-x-2 pb-4"
        >
            <ApplicationLogo width="45%" />
            <ApplicationLogo width="80%" />
            <ApplicationLogo width="45%" />
        </div>
        <div class="relative w-full">
            <input
                type="text"
                v-model="query"
                max="46"
                @input="fetchSuggestionsWithDelay"
                placeholder="Pesquisar "
                class="w-full rounded-t-lg px-4 py-2 pr-10 shadow ring-transparent focus:outline-none sm:px-6 sm:py-3"
                :class="[query ? 'border-b-0' : 'rounded-b-lg']"
            />
            <img
                class="absolute right-3 top-1/2 h-6 w-6 -translate-y-1/2 transform text-gray-500"
                src="/img/search-icon.svg"
            />

            <div
                class="absolute z-10 mt-0 w-full rounded-b-lg border border-gray-500 bg-white shadow-lg"
                v-if="query"
            >
                <p v-if="isLoading" class="px-4 py-2 text-sm text-gray-500">
                    Carregando...
                </p>
                <p
                    v-else-if="!hasSuggestions"
                    class="px-4 py-2 text-sm text-gray-500"
                >
                    Nenhum resultado encontrado
                </p>
                <ul v-else-if="suggestions">
                    <li
                        v-for="suggestion in suggestions"
                        :key="suggestion"
                        @click="selectSuggestion(suggestion)"
                        class="cursor-pointer px-4 py-2 hover:bg-gray-200"
                    >
                        {{ suggestion }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
