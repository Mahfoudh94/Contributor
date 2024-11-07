<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import LogoFull from '@images/LogoFull.svg';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div
                class="absolute start-0 top-0 h-screen w-screen bg-gradient-to-br from-blue-600/5 to-cyan-200/5"
            ></div>
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="grid grid-cols-2 items-center gap-2 rounded-full bg-gray-200/5 px-8 py-3 lg:grid-cols-4"
                >
                    <div class="flex lg:col-start-1 lg:justify-start">
                        <img :src="LogoFull" class="fill-current" alt="" />
                    </div>
                    <div class="col-span-2 flex flex-row gap-x-5 justify-self-center">
                        <Button
                            severity="secondary"
                            size="large"
                            pt:root:class="!p-2"
                            :text="!route().current('Homepage')"
                            :disabled="route().current('Homepage')"
                            rounded
                        >
                            Home
                        </Button>
                        <Button
                            severity="secondary"
                            size="large"
                            :text="!route().current('Page')"
                            :disabled="route().current('Page')"
                            rounded
                        >
                            Page 1
                        </Button>
                        <Button
                            severity="secondary"
                            size="large"
                            :text="!route().current('Another')"
                            :disabled="route().current('Another')"
                            rounded
                        >
                            Page 2
                        </Button>
                        <Button
                            severity="secondary"
                            size="large"
                            :text="!route().current('About_us')"
                            :disabled="route().current('About_us')"
                            rounded
                        >
                            About us
                        </Button>
                    </div>
                    <!--                    <IconField>-->
                    <!--                        <InputIcon class="pi pi-search" />-->
                    <!--                        <InputText v-model="searchQuery" placeholder="Search" />-->
                    <!--                        <Button>Go</Button>-->
                    <!--                    </IconField>-->
                    <nav class="-mx-3 flex flex-1 justify-end">
                        <template v-if="$page.props.auth.user">
                            <!--                            :href="route('dashboard')"-->
                            <!--                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"-->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
                                        >
                                            {{ $page.props.auth.user.name }}

                                            <svg
                                                class="-me-0.5 ms-2 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                    >
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </template>

                        <template v-else>
                            <Link :href="route('register')" class="mx-723">
                                <Button
                                    severity="contrast"
                                    size="large"
                                    rounded
                                    text
                                >
                                    Register
                                </Button>
                            </Link>

                            <Link :href="route('login')" class="mx-2">
                                <Button size="large" rounded> Log in </Button>
                            </Link>
                        </template>
                    </nav>
                </header>
                <transition>
                    <main class="mt-6 flex flex-col items-center min-h-[66vh]" :key="$page.url">
                        <slot />
                    </main>
                </transition>
            </div>
        </div>
        <footer class="flex w-full flex-col items-center bg-gray-800 pb-6 pt-12 gap-10">
            <img :src="LogoFull" alt="Contributors logo" class="max-h-20" />
            <Divider />
            <div class="flex w-full flex-col justify-between px-20 md:flex-row">
                <span class="flex flex-row items-center gap-4">
                    <Icon name="hi-mail" class="fill-primary stroke-black stroke-1" scale="1.5" />
                    contact@contributors.com
                </span>
                <span class="flex flex-row items-center gap-4">
                    <Icon name="hi-phone" class="fill-primary stroke-black stroke-1" scale="1.5" />
                    + 213 444 75 13 59
                </span>
                <span class="flex flex-row items-center gap-4">
                    <Icon name="hi-solid-location-marker" class="fill-primary stroke-black stroke-1" scale="1.5" />
                    Somewhere in the world (maybe...)
                </span>
            </div>
            <Divider />
            <div
                class="grid w-full grid-cols-3 flex-col-reverse items-center justify-between justify-items-center gap-4 px-20 md:grid"
            >
                <div class="flex flex-row items-center gap-4">
                    <a href="" class="rounded-full aspect-square bg-primary p-2">
                        <Icon name="fa-facebook" scale="1.5" class="fill-black" />
                    </a>
                    <a href="" class="rounded-full aspect-square bg-primary p-2">
                        <Icon name="fa-twitter" scale="1.5" class="fill-black" />
                    </a>
                    <a href="" class="rounded-full aspect-square bg-primary p-2">
                        <Icon name="fa-linkedin" scale="1.5" class="fill-black" />
                    </a>
                </div>
                <p class="text-gray-400">Contributors, All rights reserved</p>
                <div class="flex flex-row">
                    <a href="" class="transition duration-150 hover:text-gray-100">Privacy Policy</a>
                    <Divider layout="vertical" />
                    <a href="" class="transition duration-150 hover:text-gray-100">Terms of Service</a>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped></style>
