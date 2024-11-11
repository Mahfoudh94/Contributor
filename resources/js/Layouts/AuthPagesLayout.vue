<script setup lang="ts">
import Pattern from "@images/Pattern2.png";
import LogoFull from "@images/LogoFull.svg";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="relative flex h-screen w-screen flex-col overflow-x-hidden bg-zinc-950 px-12"
    >
        <img
            :src="Pattern"
            alt=""
            class="absolute end-0 top-0 w-5/12 -translate-y-1/4"
        />
        <nav
            class="relative my-8 flex h-16 w-full items-center justify-start gap-8 px-8"
        >
            <img :src="LogoFull" alt="" class="max-h-full w-auto pb-1.5" />
            <Link
                class="text-lg font-medium text-white/60 transition duration-200 hover:text-white"
                :href="route('Homepage')"
            >
                Home
            </Link>
            <Link
                class="text-lg font-medium text-white/60 transition duration-200 hover:text-white"
                :href="route('login')"
                replace
            >
                Join us
            </Link>
        </nav>
        <div class="relative">
            <transition name="fade">
                <main class="w-1/2 px-8 absolute" :key="$page.url">
                    <slot />
                </main>
            </transition>
        </div>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
