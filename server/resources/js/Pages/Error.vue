<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: Number,
        default: 500,
    },
});

const errors = {
    503: {
        title: 'Serviço Indisponível',
        description:
            'Desculpe, estamos fazendo manutenção. Por favor, volte em breve.',
    },
    500: {
        title: 'Erro no Servidor',
        description: 'Ops, algo deu errado em nossos servidores.',
    },
    404: {
        title: 'Não Encontrada',
        description:
            'Desculpe, a página que você está procurando não pôde ser encontrada.',
    },
    403: {
        title: 'Proibido',
        description:
            'Desculpe, você não tem permissão para acessar esta página.',
    },
};

const { title, description } = errors[props.status] || {
    title: 'Erro',
    description: 'Ocorreu um erro inesperado.',
};
</script>

<template>
    <Head :title="title" />
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-body p-6 text-center"
    >
        <img
            class="mb-6 w-96 rounded-lg shadow-lg"
            :src="`https://http.dog/${props.status}.jpg`"
            :alt="title"
            @error="
                (event) =>
                    (event.target.src =
                        'https://via.placeholder.com/300x200?text=Erro')
            "
        />
        <p class="mb-8 text-lg leading-relaxed drop-shadow-lg">
            {{ description }}
        </p>
        <PrimaryButton
            @click="router.get(route('home'))"
            class="transform rounded-lg px-8 py-4 text-xl transition-all duration-300 ease-in-out hover:scale-105"
        >
            Voltar para Página Inicial
        </PrimaryButton>
    </div>
</template>
