<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="bg-gray-100 flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="fill-current text-gray-500 h-20 w-20" />
            </Link>
        </div>

        <div
            class="bg-white mt-6 w-full overflow-hidden px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
