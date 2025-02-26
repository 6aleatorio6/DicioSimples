<script lang="ts" setup>
import ListVertical from '@/Components/List.vue';
import { Head, Link } from '@inertiajs/vue3';

interface WordRelation {
    word: string;
    id: number;
}

defineProps<{
    word: string;
    baseForm?: WordRelation;
    meanings: { title: string; explanation: string }[];
    wordSynonyms: WordRelation[];
    wordAntonyms: WordRelation[];
}>();

function capWord(word: string): string {
    return word.charAt(0).toUpperCase() + word.slice(1);
}
</script>

<template>
    <Head :title="capWord(word)" />
    <section class="mt-7">
        <h1 class="ms- text-4xl font-bold uppercase">{{ word }}</h1>
        <div class="my-1 border-b-2 border-gray-400" />
        <p v-if="baseForm" class="ms-4 text-lg">
            Forma base:
            <Link :href="route('word', baseForm.word)">
                <span class="text-blue-800 underline">{{
                    capWord(baseForm.word)
                }}</span>
            </Link>
        </p>
    </section>
    <section class="mt-4">
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
            v-if="wordSynonyms.length"
            title="Palavras com sentido semelhante"
            :listWord="wordSynonyms"
        />
        <div
            v-if="wordSynonyms.length && wordAntonyms.length"
            class="mx-4 border-l-2 border-gray-300"
        ></div>
        <ListVertical
            v-if="wordAntonyms.length"
            title="Palavras com sentido contrário"
            :listWord="wordAntonyms"
        />
    </section>
    <Link
        :href="route('home')"
        class="rounded bg-bodyTri px-4 py-1 text-xl font-bold"
    >
        Voltar
    </Link>
</template>
