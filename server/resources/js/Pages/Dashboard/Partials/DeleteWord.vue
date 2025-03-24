<script setup lang="ts">
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Word } from '@/types/words';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{ wordContent: Word | null }>();
const emit = defineEmits(['close']);

// Cria o formulário para envio da requisição de exclusão
const form = useForm({});

// Função que envia a requisição DELETE para excluir a palavra
const deleteWord = () => {
    form.delete(route('admin.words.destroy', props.wordContent!.id), {
        preserveScroll: true,
        onFinish: () => {
            // Fecha o modal após a operação
            emit('close');
        },
    });
};
</script>

<template>
    <Modal :show="!!wordContent">
        <div v-if="wordContent" class="p-6">
            <!-- Título de confirmação -->
            <h2 class="text-lg font-medium text-gray-900">
                Confirma a exclusão da palavra
                <span class="font-bold">{{ wordContent.word }}</span
                >?
            </h2>

            <!-- Descrição da ação -->
            <p class="mt-2 text-base text-gray-600">
                Atenção: ao excluir esta palavra, ela será removida
                permanentemente do sistema e deixará de ser exibida como
                sinônimo ou antônimo em outras palavras.
            </p>

            <!-- Botões de ação -->
            <div class="mt-6 flex justify-end space-x-3">
                <SecondaryButton @click="emit('close')">
                    Cancelar
                </SecondaryButton>
                <DangerButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="deleteWord"
                >
                    <span v-if="form.processing">Excluindo...</span>
                    <span v-else>Excluir Palavra</span>
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
