<script lang="ts" setup>
import List from '@/Components/List.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SectionContent from '@/Components/SectionContent.vue';
import { capWord } from '@/helpers';
import { WordRelation } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    word: string;
    baseForm?: WordRelation;
    meanings: { title: string; explanation: string }[];
    wordSynonyms: WordRelation[];
    wordAntonyms: WordRelation[];
}>();
</script>

<template>
    <Head :title="capWord(word)" />
    <section class="mt-8">
        <h1 class="text-5xl font-bold uppercase">{{ word }}</h1>
        <div class="my-1 border-b-2 border-gray-400" />
        <p v-if="baseForm && baseForm.word !== word" class="ms-4 text-lg">
            Palavra base:
            <Link :href="route('word', baseForm.word)">
                <span class="text-blue-800 underline">{{
                    capWord(baseForm.word)
                }}</span>
            </Link>
        </p>
    </section>

    <SectionContent title="Definições">
        <div
            v-for="(meaning, index) in meanings"
            :key="index"
            class="mt-2 text-lg"
        >
            <h3 class="inline font-bold">
                {{ index + 1 }}. {{ meaning.title }}
            </h3>
            <span> – </span>
            <p class="inline">{{ meaning.explanation }}</p>
        </div>
    </SectionContent>

    <SectionContent title="Sinônimos">
        <List
            startText="Palavras com significado semelhante: "
            emptyListText="Nenhum sinônimo disponível para esta palavra"
            :listWord="wordSynonyms"
            title="Sinônimos"
        />
    </SectionContent>

    <SectionContent title="Antônimos">
        <List
            startText="Palavras com significado oposto: "
            emptyListText="Nenhum antônimo disponível para esta palavra"
            :listWord="wordAntonyms"
            title="Antônimos"
        />
    </SectionContent>

    <Link :href="route('home')" class="m-auto my-10 w-8/12">
        <PrimaryButton class="h-14 w-full justify-center text-2xl">
            Buscar outra palavra
        </PrimaryButton>
    </Link>
</template>
