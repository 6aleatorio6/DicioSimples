<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { capWord } from '@/helpers';
import { Word } from '@/types/words';
import { computed, defineProps } from 'vue';

export interface WordRelation {
    word: string;
    id: number;
}

const props = defineProps<{ wordContent: Word | null }>();
defineEmits(['close']);

const hasSynonyms = computed(() => props.wordContent?.wordSynonyms.length);
const hasAntonyms = computed(() => props.wordContent?.wordAntonyms.length);
const hasBaseForm = computed(
    () =>
        props.wordContent?.baseForm?.word &&
        props.wordContent?.baseForm?.word !== props.wordContent?.word,
);
</script>

<template>
    <Modal :show="!!wordContent">
        <div v-if="wordContent" class="p-6">
            <!-- Cabeçalho -->
            <header class="mb-4 border-b pb-3">
                <h2 class="text-3xl font-bold text-gray-800">
                    {{ capWord(wordContent.word) }}
                </h2>
                <p
                    v-if="wordContent.partOfSpeech"
                    class="text-lg text-gray-600"
                >
                    {{ capWord(wordContent.partOfSpeech) }}
                    <template v-if="hasBaseForm">
                        de
                        <span class="font-semibold text-blue-600">{{
                            capWord(wordContent.baseForm!.word)
                        }}</span>
                    </template>
                </p>
            </header>

            <!-- Significados -->
            <section>
                <h3 class="text-xl font-semibold text-gray-700">
                    Significados
                </h3>
                <div class="mt-2 space-y-4">
                    <div
                        v-for="(meaning, index) in wordContent.meanings"
                        :key="index"
                        class="rounded bg-gray-50 p-4 shadow"
                    >
                        <h4 class="text-lg font-medium text-gray-700">
                            {{ meaning.title }}
                        </h4>
                        <p class="text-gray-600">{{ meaning.explanation }}</p>
                    </div>
                </div>
            </section>

            <!-- Sinônimos e Antônimos -->
            <section class="mt-6">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Sinônimos -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">
                            Sinônimos
                        </h3>
                        <div class="ms-2 mt-2">
                            <template v-if="hasSynonyms">
                                <ul class="list-inside list-disc">
                                    <li
                                        v-for="syn in wordContent.wordSynonyms"
                                        :key="syn.id"
                                    >
                                        {{ capWord(syn.word) }}
                                    </li>
                                </ul>
                            </template>
                            <template v-else>
                                <p class="text-gray-600">
                                    Nenhum sinônimo disponível.
                                </p>
                            </template>
                        </div>
                    </div>

                    <!-- Antônimos -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700">
                            Antônimos
                        </h3>
                        <div class="ms-2 mt-2">
                            <template v-if="hasAntonyms">
                                <ul class="list-inside list-disc">
                                    <li
                                        v-for="ant in wordContent.wordAntonyms"
                                        :key="ant.id"
                                    >
                                        {{ capWord(ant.word) }}
                                    </li>
                                </ul>
                            </template>
                            <template v-else>
                                <p class="text-gray-600">
                                    Nenhum antônimo disponível.
                                </p>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Rodapé -->
            <footer class="mt-6 flex justify-end">
                <PrimaryButton @click="$emit('close')">Fechar</PrimaryButton>
            </footer>
        </div>
    </Modal>
</template>
