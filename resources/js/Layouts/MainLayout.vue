<script setup lang="ts">
import LocalDropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import LogoFull from '@images/LogoFull.svg';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 overflow-y-hidden">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div
                class="fixed start-0 top-0 h-screen w-screen bg-gradient-to-br from-blue-600/5 to-cyan-200/5"
            ></div>
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="my-8 grid grid-cols-2 items-center gap-2 rounded-full bg-gray-200/5 px-8 py-3 lg:grid-cols-4"
                >
                    <div class="flex lg:col-start-1 lg:justify-start">
                        <img :src="LogoFull" class="fill-current" alt="" />
                    </div>
                    <div
                        class="col-span-2 flex flex-row gap-x-5 justify-self-center"
                    >
                        <Link :href="route('Homepage')">
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
                        </Link>
                        <Link :href="''">
                            <Button
                                severity="secondary"
                                size="large"
                                :text="!route().current('Page')"
                                :disabled="route().current('Page')"
                                rounded
                            >
                                Page 1
                            </Button>
                        </Link>
                        <Link :href="''">
                            <Button
                                severity="secondary"
                                size="large"
                                :text="!route().current('Another')"
                                :disabled="route().current('Another')"
                                rounded
                            >
                                Page 2
                            </Button>
                        </Link>
                        <Link :href="''">
                            <Button
                                severity="secondary"
                                size="large"
                                :text="!route().current('About_us')"
                                :disabled="route().current('About_us')"
                                rounded
                            >
                                About us
                            </Button>
                        </Link>
                    </div>
                    <!--                    <IconField>-->
                    <!--                        <InputIcon class="pi pi-search" />-->
                    <!--                        <InputText v-model="searchQuery" placeholder="Search" />-->
                    <!--                        <Button>Go</Button>-->
                    <!--                    </IconField>-->
                    <nav class="-mx-3 flex flex-1 justify-end">
                        <template v-if="$page.props.auth.user">
                            <LocalDropdown>
                                <template #trigger>
                                    <Avatar
                                        size="large"
                                        :image="$page.props.auth.user.avatarUrl"
                                        v-if="$page.props.auth.user.avatarUrl"
                                        class="hover:saturation-75 hover:brightness-120 transition-all duration-200 hover:scale-110"
                                    />
                                    <Avatar
                                        shape="circle"
                                        size="large"
                                        class="hover:saturation-75 hover:brightness-120 p-2 transition-all duration-200 hover:scale-110"
                                        v-else
                                    >
                                        <template #icon>
                                            <Icon width="" height="" name="fa-user" />
                                        </template>
                                    </Avatar>
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
                            </LocalDropdown>
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
                <Card class="my-4" v-if="!!$page.props.flash.message">
                    <template #content>
                        <p>{{ $page.props.flash.message }}</p>
                    </template>
                </Card>
                <transition name="fade">
                    <main
                        class="mt-6 flex min-h-[66vh] flex-col items-center"
                        :key="$page.url"
                    >
                        <slot />
                    </main>
                </transition>
            </div>
        </div>
        <footer
            class="flex w-full flex-col items-center gap-10 bg-gray-800 pb-6 pt-12"
        >
            <img :src="LogoFull" alt="Contributors logo" class="max-h-20" />
            <Divider />
            <div class="flex w-full flex-col justify-between px-20 md:flex-row">
                <span class="flex flex-row items-center gap-4">
                    <Icon
                        name="hi-mail"
                        class="fill-primary stroke-black stroke-1"
                        scale="1.5"
                    />
                    contact@contributors.com
                </span>
                <span class="flex flex-row items-center gap-4">
                    <Icon
                        name="hi-phone"
                        class="fill-primary stroke-black stroke-1"
                        scale="1.5"
                    />
                    + 213 444 75 13 59
                </span>
                <span class="flex flex-row items-center gap-4">
                    <Icon
                        name="hi-solid-location-marker"
                        class="fill-primary stroke-black stroke-1"
                        scale="1.5"
                    />
                    Somewhere in the world (maybe...)
                </span>
            </div>
            <Divider />
            <div
                class="grid w-full grid-cols-3 flex-col-reverse items-center justify-between justify-items-center gap-4 px-20 md:grid"
            >
                <div class="flex flex-row items-center gap-4">
                    <a
                        href=""
                        class="aspect-square rounded-full bg-primary p-2"
                    >
                        <Icon
                            name="fa-facebook"
                            scale="1.5"
                            class="fill-black"
                        />
                    </a>
                    <a
                        href=""
                        class="aspect-square rounded-full bg-primary p-2"
                    >
                        <Icon
                            name="fa-twitter"
                            scale="1.5"
                            class="fill-black"
                        />
                    </a>
                    <a
                        href=""
                        class="aspect-square rounded-full bg-primary p-2"
                    >
                        <Icon
                            name="fa-linkedin"
                            scale="1.5"
                            class="fill-black"
                        />
                    </a>
                </div>
                <p class="text-gray-400">Contributors, All rights reserved</p>
                <div class="flex flex-row">
                    <a
                        href=""
                        class="transition duration-150 hover:text-gray-100"
                        >Privacy Policy</a
                    >
                    <Divider layout="vertical" />
                    <a
                        href=""
                        class="transition duration-150 hover:text-gray-100"
                        >Terms of Service</a
                    >
                </div>
            </div>
        </footer>
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
