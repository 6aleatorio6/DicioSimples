<script lang="ts" setup>
const props = defineProps<{
    title: string;
    listWord: string[];
}>();

const isEnd = (i: number, add: number) => props.listWord.length === i + add;
</script>

<template>
    <div class="flex space-x-4">
        <h2 class="text-xl font-bold">{{ title }}:</h2>
        <ul class="flex">
            <li
                v-for="(item, idx) in listWord"
                :key="idx"
                class="text list-none pe-1"
            >
                <template v-if="isEnd(idx, 1)">{{ item }} </template>
                <template v-else-if="isEnd(idx, 2)">{{ item }} e</template>
                <template v-else>{{ item + ',' }}</template>
            </li>
        </ul>
    </div>
</template>
