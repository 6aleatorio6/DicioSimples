<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    resultSearch: string[];
}>();

const query = ref('');
const suggestions = ref<string[]>([]);

const fetchSuggestions = () => {
    if (!query.value) {
        suggestions.value = [];
        return;
    }

    router.reload({
        data: { s: query.value },
        onSuccess: () => {
            suggestions.value = props.resultSearch;
        },
    });
};

const selectSuggestion = (suggestion: string) => {
    query.value = suggestion;
    suggestions.value = [];
};
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
                @input="fetchSuggestions"
                placeholder="Pesquisar "
                class="w-full rounded-t-lg px-4 py-2 pr-10 shadow ring-transparent focus:outline-none sm:px-6 sm:py-3"
                :class="[suggestions.length ? 'border-b-0' : 'rounded-b-lg']"
            />
            <img
                class="absolute right-3 top-1/2 h-6 w-6 -translate-y-1/2 transform text-gray-500"
                src="img/search-icon.svg"
            />
            <ul
                v-if="suggestions.length"
                class="absolute z-10 mt-0 w-full rounded-b-lg border border-gray-500 bg-white shadow-lg"
            >
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
</template>
