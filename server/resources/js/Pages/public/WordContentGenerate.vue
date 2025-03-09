<script lang="ts" setup>
import LineSpinner from '@/Components/LineSpinner.vue';
import { capWord } from '@/helpers';
import { Head, router } from '@inertiajs/vue3';
import { onUnmounted } from 'vue';

const { word } = defineProps<{ word: string }>();

let isGeneration = false;
onUnmounted(() => (isGeneration = true));

const fetchRecursively = () => {
    if (isGeneration) return;
    setTimeout(() => {
        router.reload({ onSuccess: fetchRecursively });
    }, 1000);
};
fetchRecursively();
</script>

<template>
    <Head :title="capWord(word)" />
    <div
        class="m-auto mt-44 flex flex-col items-center justify-center gap-1 md:w-[400px]"
    >
        <!-- Title and message -->
        <LineSpinner />
        <h3 class="text-xl font-extrabold text-text">Aguarde...</h3>
        <p class="text-lg text-text">
            Estamos gerando o conteúdo para a palavra
        </p>
    </div>
</template>
