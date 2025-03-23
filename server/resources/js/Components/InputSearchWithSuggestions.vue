<script lang="ts" setup>
import { useToggle } from '@/helpers';
import { ref, watch } from 'vue';
import LineSpinner from './LineSpinner.vue';

const emit = defineEmits<{
    fetchSuggestions: [q: string, onFinish: () => void];
    selectedWord: [suggestion: string];
}>();

const props = defineProps<{ suggestions?: string[] }>();

const query = ref('');
const wordSelected = ref<string | undefined>();

const suggestionsDiv = ref<HTMLDivElement | null>(null); // Ref para a div de sugestões
watch(
    () => props.suggestions,
    () => {
        wordSelected.value = props.suggestions?.[0];

        suggestionsDiv.value!.scrollIntoView({
            behavior: 'smooth',
            block: 'center',
        });
    },
);

/**
 * Ao rodar essa função, a palavra selecionada é emitida para o componente pai.
 * islLoadingWord é setado para true, para que o input seja desabilitado e a caixa de sugestões seja fechada.
 */
const [isLoadingWord, tIsLoadingWord] = useToggle(false);
const selectWord = () => {
    if (!wordSelected.value) return;
    query.value = wordSelected.value;
    tIsLoadingWord();
    emit('selectedWord', wordSelected.value);
};

/**
 * Ao rodar essa função, a query é emitida para o componente pai.
 * Com isloadingSuggestion true, a caixa de sugestões é exibida mostrando que está carregando.
 */
const isLoadingSuggestion = ref(false);
const fetchSuggestionsEmit = () => {
    isLoadingSuggestion.value = true;
    emit(
        'fetchSuggestions',
        query.value,
        () => (isLoadingSuggestion.value = false),
    );
};

const moveSelected = (distance: number) => {
    if (!props.suggestions?.length) return;
    const index = props.suggestions.indexOf(wordSelected.value!);

    let newIndex = index + distance;
    if (newIndex < 0) newIndex = props.suggestions.length - 1;
    if (newIndex >= props.suggestions.length) newIndex = 0;

    wordSelected.value = props.suggestions[newIndex];
};

//
</script>

<template>
    <div class="relative w-full">
        <input
            v-bind="$attrs"
            @input="fetchSuggestionsEmit"
            @keydown.down.prevent="moveSelected(1)"
            @keydown.up.prevent="moveSelected(-1)"
            @keydown.enter.prevent="selectWord"
            type="text"
            v-model="query"
            max="46"
            :disabled="isLoadingWord"
            placeholder="Pesquisar "
            class="w-full rounded-t-lg px-4 py-2 pr-10 text-text shadow ring-transparent focus:outline-none disabled:bg-body-200 sm:px-6 sm:py-3"
            :class="[query && !isLoadingWord ? 'border-b-0' : 'rounded-b-lg']"
        />
        <img
            class="absolute right-3 top-1/2 h-6 w-6 -translate-y-1/2 transform text-textSec"
            src="/img/search-icon.svg"
        />

        <div
            class="absolute z-10 mt-0 w-full rounded-b-lg border border-gray-500 bg-white pb-1 shadow-lg"
            v-show="query && !isLoadingWord"
        >
            <ul
                class="divide-y divide-gray-200"
                @mouseleave="wordSelected = props.suggestions?.[0]"
                ref="suggestionsDiv"
            >
                <li v-if="isLoadingSuggestion" class="px-4 py-2">
                    Carregando...
                </li>
                <li v-else-if="!suggestions?.length" class="px-4 py-2">
                    Nenhuma sugestão encontrada
                </li>
                <li
                    v-else
                    v-for="suggestion in suggestions"
                    :key="suggestion"
                    @click="selectWord"
                    @mouseenter="wordSelected = suggestion"
                    :class="{ 'bg-gray-100': wordSelected == suggestion }"
                    class="cursor-pointer px-4 py-2 sm:px-6"
                >
                    {{ suggestion }}
                </li>
            </ul>
        </div>
    </div>
    <LineSpinner v-if="isLoadingWord" class="mt-20 text-center" />
</template>
