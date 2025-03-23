<script lang="ts" setup>
import List from '@/Components/List.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SectionContent from '@/Components/SectionContent.vue';
import { capWord } from '@/helpers';
import { WordRelation } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    word: string;
    partOfSpeech: string;
    baseForm?: WordRelation;
    meanings: { title: string; explanation: string }[];
    wordSynonyms: WordRelation[];
    wordAntonyms: WordRelation[];
}>();

const hasBaseForm = props.baseForm?.word && props.baseForm?.word !== props.word;
const hasSynonyms = props.wordSynonyms.length;
const hasAntonyms = props.wordAntonyms.length;

const baseFormCap = hasBaseForm ? capWord(props.baseForm.word) : '';

function createDescription(): string {
    const parts: string[] = [
        `Descubra o significado de ${capWord(props.word)}!`,
    ];

    if (props.meanings.length)
        parts.push(
            `Suas definições incluem: ${props.meanings.map((m) => m.title).join(', ')}.`,
        );

    const format = (w: WordRelation[]) =>
        w.map(({ word }) => capWord(word)).join(', ');

    if (props.wordSynonyms.length)
        parts.push(
            `Entre seus sinônimos, temos: ${format(props.wordSynonyms)}.`,
        );
    if (props.wordAntonyms.length)
        parts.push(`E seus antônimos são: ${format(props.wordAntonyms)}.`);

    return parts.join(' ');
}
</script>

<template>
    <Head>
        <title>{{ capWord(word) }}</title>
        <meta name="description" :content="createDescription()" />
    </Head>
    <div class="gap- flex flex-col">
        <section class="mt-6 sm:mt-14">
            <h1 class="text-5xl font-bold uppercase">{{ word }}</h1>
            <div class="my-1 border-b-2 border-bodySec" />
            <p v-if="partOfSpeech" class="ms-2 text-lg text-text-400">
                {{ capWord(partOfSpeech) }}
                <template v-if="hasBaseForm">
                    de
                    <Link :href="route('word', baseForm!.word)">
                        <span class="text-blue-800 underline">{{
                            baseFormCap
                        }}</span>
                    </Link>
                </template>
            </p>
        </section>
        <SectionContent title="Explicações">
            <div
                v-for="(meaning, index) in meanings"
                :key="index"
                class="mt-3 text-lg"
            >
                <h3
                    class="w-fit rounded-2xl bg-bodySec px-2 text-sm font-bold capitalize text-textSec"
                >
                    {{ meaning.title }}
                </h3>
                <p class="text-text-500">{{ meaning.explanation }}</p>
            </div>
        </SectionContent>

        <SectionContent v-if="hasSynonyms" title="Sinônimos">
            <List
                startText="Palavras com significado semelhante: "
                emptyListText="Nenhum sinônimo disponível para esta palavra"
                :listWord="wordSynonyms"
                title="Sinônimos"
            />
        </SectionContent>

        <SectionContent v-if="hasAntonyms" title="Antônimos">
            <List
                startText="Palavras com significado oposto: "
                emptyListText="Nenhum antônimo disponível para esta palavra"
                :listWord="wordAntonyms"
                title="Antônimos"
            />
        </SectionContent>
    </div>

    <Link :href="route('home')" class="m-auto my-16 sm:w-7/12">
        <PrimaryButton
            class="w-full justify-center py-4 text-lg sm:py-6 sm:text-xl"
        >
            Buscar outra palavra
        </PrimaryButton>
    </Link>
</template>
