<script lang="ts" setup>
import { WordRelation } from '@/types';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    startText: string;
    emptyListText: string;
    listWord: Pick<WordRelation, 'word'>[];
}>();

const isLastItem = (i: number, add: number) =>
    props.listWord.length === i + add;
</script>

<template>
    <ul class="flex flex-wrap text-lg" v-if="listWord.length">
        <span class="me-1">{{ startText }}</span>
        <li
            v-for="(item, idx) in listWord"
            :key="idx"
            class="mt-auto list-none pe-1"
        >
            <Link
                :href="route('word', item.word.toLowerCase())"
                class="text-blue-800 underline"
            >
                {{ item.word }}
            </Link>
            <span>
                {{
                    isLastItem(idx, 2) ? ' e ' : !isLastItem(idx, 1) ? ', ' : ''
                }}
            </span>
        </li>
    </ul>
    <p v-else class="text-lg">{{ emptyListText }}</p>
</template>
