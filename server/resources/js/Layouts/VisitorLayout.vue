<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    laravelVersion: string;
    phpVersion: string;
    canLogin: boolean;
}>();
</script>

<template>
    <div class="">
        <div class="flex h-[99vh] flex-col bg-body font-inter text-text">
            <header
                class="flex flex-col items-center justify-between gap-4 bg-bodySec px-4 py-4 sm:flex-row lg:grid lg:grid-cols-6"
            >
                <Link
                    href="/"
                    class="flex flex-col items-center pt-4 sm:items-start lg:col-span-4 lg:col-start-2 lg:items-center"
                >
                    <h1
                        class="py-3 font-Jomhuria text-6xl !leading-3 sm:text-7xl lg:text-8xl"
                    >
                        <span class="text-text">Dicio</span>
                        <span class="text-textSec">Simples</span>
                    </h1>
                    <h2
                        class="text-center text-lg text-textSec sm:text-left sm:text-xl lg:text-lg"
                    >
                        Dicionário com explicações simples e fáceis de
                        compreender
                    </h2>
                </Link>
                <nav class="lg:col-span-1">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="rounded bg-bodyTri px-4 py-2 text-text hover:bg-bodyTri/70"
                    >
                        Dashboard
                    </Link>
                </nav>
            </header>

            <main class="flex flex-grow flex-col">
                <slot />
            </main>
        </div>

        <footer class="w-full bg-bodySec">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!--Grid-->
                <div
                    class="flex flex-col items-center justify-between gap-8 py-8 lg:flex-row"
                >
                    <div>
                        <ApplicationLogo :width="80" />
                        <div class="mt-2 flex h-8 justify-between">
                            <a
                                href="https://www.linkedin.com/in/leonardo-l-felix"
                                class="flex items-center justify-center rounded-full hover:opacity-30"
                            >
                                <img
                                    src="img/linkedin-icon.png"
                                    alt="LinkedIn"
                                    class="h-full"
                                />
                            </a>
                            <a
                                href="https://github.com/6aleatorio6"
                                class="flex items-center justify-center rounded-full hover:opacity-30"
                            >
                                <img
                                    src="img/github-icon.svg"
                                    alt="GitHub"
                                    class="h-full"
                                />
                            </a>
                        </div>
                    </div>
                    <p class="text-center text-lg sm:w-1/2 lg:w-3/12">
                        O DicioSimples oferece definições claras e objetivas
                        para facilitar o seu entendimento.
                    </p>
                </div>
                <!--Grid-->

                <div class="border-t border-gray-700 py-3 text-center">
                    <div class="flex flex-col items-center">
                        <span class="">
                            © 2025
                            <a
                                class="text-blue-500 underline"
                                href="https://www.linkedin.com/in/leonardo-l-felix"
                            >
                                Leonardo L. Felix.
                            </a>
                            Todos os direitos reservados.
                        </span>
                        <span class="text-sm text-gray-500">
                            Laravel v{{ laravelVersion }} (PHP v{{
                                phpVersion
                            }})
                        </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
