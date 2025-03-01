<script lang="ts" setup>
import { ref } from 'vue';

defineProps<{
    submit: (query: string | void) => void;
    inputSearch: (query: string) => void;
    isLoading: boolean;
}>();

const query = ref('');
</script>

<template>
    <div class="relative w-full">
        <input
            type="text"
            v-model="query"
            max="46"
            @input="inputSearch(query)"
            @keyup.enter="submit(query)"
            :disabled="isLoading"
            placeholder="Pesquisar "
            class="w-full rounded-t-lg px-4 py-2 pr-10 shadow ring-transparent focus:outline-none sm:px-6 sm:py-3"
            :class="[query && !isLoading ? 'border-b-0' : 'rounded-b-lg']"
        />
        <img
            class="absolute right-3 top-1/2 h-6 w-6 -translate-y-1/2 transform text-gray-500"
            src="/img/search-icon.svg"
        />

        <div
            class="absolute z-10 mt-0 w-full rounded-b-lg border border-gray-500 bg-white pb-1 shadow-lg"
            v-show="query && !isLoading"
        >
            <slot />
        </div>
    </div>
</template>
