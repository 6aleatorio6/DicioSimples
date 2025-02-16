<script lang="ts" setup>
import ListVertical from '@/Components/List.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    word: string;
    wordBase: string;
    meanings: { title: string; explanation: string }[];
    synonyms: string[];
    antonyms: string[];
}>();

const capWord = computed(
    () => props.word.charAt(0).toUpperCase() + props.word.slice(1),
);
</script>

<template>
    <Head :title="capWord" />
    <section class="relative mt-7 flex w-full border-b-2 border-gray-400 pb-2">
        <Link
            :href="route('home')"
            class="absolute rounded bg-bodyTri px-4 py-1 text-xl font-bold"
        >
            Voltar
        </Link>
        <h1 class="m-auto text-3xl font-bold uppercase">{{ capWord }}</h1>
    </section>
    <section class="mt-4">
        <p class="text-lg">
            {{ capWord }} pode ter diferentes significados, como:
        </p>
        <div
            v-for="(meaning, index) in meanings"
            :key="index"
            class="ms-3 mt-2 text-lg"
        >
            <strong>{{ index + 1 }}. {{ meaning.title }} - </strong>
            {{ meaning.explanation }}
        </div>
    </section>
    <section class="mt-4 flex">
        <ListVertical
            v-if="synonyms.length"
            title="Palavras com sentido semelhante"
            :listWord="synonyms"
        />
        <div
            v-if="synonyms.length && antonyms.length"
            class="mx-4 border-l-2 border-gray-300"
        ></div>
        <ListVertical
            v-if="antonyms.length"
            title="Palavras com sentido contrário"
            :listWord="antonyms"
        />
    </section>
</template>
