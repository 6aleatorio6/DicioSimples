<script setup lang="ts">
defineProps<{ title: string }>();
</script>

<template>
    <section class="mt-4">
        <h2 class="text-xl font-semibold">{{ title }}</h2>
        <div class="ms-3">
            <slot />
        </div>
    </section>
</template>
