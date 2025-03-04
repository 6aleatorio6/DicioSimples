<script lang="ts" setup>
import List from '@/Components/List.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SectionContent from '@/Components/SectionContent.vue';
import { capWord } from '@/helpers';
import { WordRelation } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    word: string;
    partOfSpeech: string;
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
        <p v-if="partOfSpeech" class="ms-4 text-lg">
            {{ capWord(partOfSpeech) }}
            <template v-if="baseForm && baseForm.word !== word">
                de
                <Link :href="route('word', baseForm.word)">
                    <span class="text-blue-800 underline">{{
                        capWord(baseForm.word)
                    }}</span>
                </Link>
            </template>
        </p>
    </section>
    <SectionContent title="Definições">
        <div
            v-for="(meaning, index) in meanings"
            :key="index"
            class="mt-2 text-lg"
        >
            <h3
                class="text-textSec-700 w-fit rounded-lg text-lg font-bold capitalize"
            >
                {{ meaning.title }}
            </h3>
            <p class="text-textSec-500 ms-2">{{ meaning.explanation }}</p>
        </div>
    </SectionContent>

    <SectionContent v-if="wordSynonyms?.length" title="Sinônimos">
        <List
            startText="Palavras com significado semelhante: "
            emptyListText="Nenhum sinônimo disponível para esta palavra"
            :listWord="wordSynonyms"
            title="Sinônimos"
        />
    </SectionContent>

    <SectionContent v-if="wordAntonyms?.length" title="Antônimos">
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
