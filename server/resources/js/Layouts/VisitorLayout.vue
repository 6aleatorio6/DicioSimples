<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>
    <div class="">
        <div
            class="flex min-h-[96.5vh] flex-col bg-body font-inter text-text lg:min-h-[98vh]"
        >
            <header
                class="flex flex-col items-center justify-between bg-bodySec px-4 md:py-5 lg:grid lg:grid-cols-6"
            >
                <Link
                    href="/"
                    class="flex flex-col items-center py-3 md:py-0 lg:col-span-4 lg:col-start-2 lg:items-center"
                >
                    <h1
                        class="flex pt-2 font-Jomhuria text-7xl !leading-10 md:text-8xl"
                    >
                        <span style="color: #e6c45c">Dicio</span>
                        <span class="text-textSec">Simples</span>
                    </h1>
                    <h2
                        class="hidden text-center text-lg text-textSec md:block md:text-xl"
                    >
                        Dicionário com explicações simples e fáceis de
                        compreender
                    </h2>
                </Link>
                <nav class="lg:col-span-1">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('admin.words.index')"
                        class="rounded bg-bodySec-300 px-4 py-2 text-text-300 hover:bg-bodyTri/70"
                    >
                        admin
                    </Link>
                </nav>
            </header>

            <main class="m-auto flex w-full max-w-4xl flex-grow flex-col px-3">
                <slot />
            </main>
        </div>

        <footer class="w-full bg-bodySec text-textSec">
            <div class="mx-auto max-w-4xl px-4">
                <!--Grid-->
                <div
                    class="flex flex-col items-center justify-between py-8 sm:flex-row"
                >
                    <div class="flex w-full justify-between sm:block sm:w-auto">
                        <ApplicationLogo width="100" />
                        <div
                            class="flex w-auto flex-col-reverse justify-between rounded bg-body/55 p-1 sm:w-full sm:flex-row"
                        >
                            <a
                                href="https://www.linkedin.com/in/leonardo-l-felix"
                            >
                                <img
                                    src="/img/linkedin-icon.png"
                                    alt="LinkedIn"
                                    class="h-9 sm:h-7"
                                />
                            </a>
                            <a
                                href="https://github.com/6aleatorio6/DicioSimples"
                            >
                                <img
                                    src="/img/github-icon.svg"
                                    alt="GitHub"
                                    class="mx-auto h-9 sm:h-7"
                                />
                            </a>
                        </div>
                    </div>
                    <p class="pt-4 text-center text-lg sm:w-3/12 sm:pt-0">
                        O DicioSimples oferece definições claras e objetivas
                        para facilitar o seu entendimento.
                    </p>
                </div>
                <!--Grid-->

                <div class="border-t border-bodyTri py-3 text-center">
                    <div class="flex flex-col items-center">
                        <span class="">
                            © 2025
                            <a
                                class="text-blue-300 underline"
                                href="https://www.linkedin.com/in/leonardo-l-felix"
                            >
                                Leonardo L. Felix.
                            </a>
                            Todos os direitos reservados.
                        </span>
                        <span class="text-sm text-textSec-400">
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
