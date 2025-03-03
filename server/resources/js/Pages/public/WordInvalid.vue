<script lang="ts" setup>
import List from '@/Components/List.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { capWord } from '@/helpers';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    word: string;
    suggestions: string[];
}>();
</script>

<template>
    <Head :title="capWord(word)" />
    <div
        class="m-auto mt-44 flex flex-col items-center justify-center md:w-[400px]"
    >
        <!-- Title and message -->
        <h1 class="text-5xl font-extrabold text-text">Ops!</h1>

        <p class="mt-5 text-center text-xl text-gray-600">
            A palavra
            <span class="font-semibold text-red-600">{{ word }}</span> não é
            válida.
        </p>
        <p class="text-center">
            Verifique a ortografia ou tente outra palavra.
        </p>

        <!-- Button to go back to the home page -->
        <Link :href="route('home')" class="mt-3 w-full">
            <PrimaryButton class="h-12 w-full justify-center">
                Voltar para a Página Inicial
            </PrimaryButton>
        </Link>

        <!-- Suggestions list -->
        <List
            v-if="suggestions.length"
            startText=""
            emptyListText="Nenhuma sugestão disponível."
            class="mt-2 items-center justify-center text-sm"
            :listWord="
                suggestions.map((suggestion) => ({ word: capWord(suggestion) }))
            "
        />
    </div>
</template>
