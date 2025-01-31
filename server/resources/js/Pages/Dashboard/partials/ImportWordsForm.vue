<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { useTemplateRef } from 'vue';

const inputRef = useTemplateRef('inputRef');
const formRef = useTemplateRef('formRef');

const form = useForm({ file: null });

function input($event: Event) {
    form.file = ($event.target as any).files[0];
    form.post(route('words.import'), { onSuccess: () => form.reset() });
    formRef.value?.reset();
}
</script>

<template>
    <div class="flex gap-4">
        <PrimaryButton
            type="button"
            @click="inputRef!.click()"
            class="relative w-56 items-center justify-center"
        >
            <p v-if="form.recentlySuccessful" class="text-green-400">
                Sucesso!
            </p>
            <p v-else-if="!form.processing">Importar Palavras - CSV</p>
            <p v-else class="text-yellow-500">Aguarde...</p>

            <form ref="formRef">
                <input
                    class="hidden"
                    type="file"
                    ref="inputRef"
                    @input="input"
                />
            </form>
        </PrimaryButton>
    </div>
</template>
