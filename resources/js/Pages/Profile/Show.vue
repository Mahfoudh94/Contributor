<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import { User } from '@/types/model';
import pattern from '@images/Pattern2.png';
import { PageProps } from '@inertiajs/core';
import { Head, Link, usePage } from '@inertiajs/vue3';
interface propsInterface extends PageProps {
    profile: User;
}

const $page = usePage<propsInterface>();

const badgeIconColorizer = {};
</script>

<template>
    <Head title="Profile" />
    <MainLayout>
        <div class="h-16"></div>
        <Card
            class="w-full bg-surface-700"
            pt:content:class="relative w-full overflow-hidden min-h-20 flex flex-col md:grid grid-cols-3"
        >
            <template #content>
                <img
                    :src="pattern"
                    alt=""
                    class="absolute end-0 top-0 max-h-full w-max -translate-y-10 translate-x-12"
                />
                <div
                    class="col-start-1 flex flex-col items-center justify-center"
                >
                    <img
                        class="m-12 aspect-square h-auto w-full max-w-[calc(100%-4rem)] rounded-full border border-primary-500/40 object-cover p-8"
                        :src="$page.props.profile.profile_picture_url"
                        alt=""
                    />
                    <div
                        v-if="$page.props.profile.badges?.length"
                        class="flex flex-col gap-2"
                    >
                        <div
                            class="grid h-12 grid-cols-[auto_1fr] grid-rows-2 gap-x-2"
                            v-for="badge in $page.props.profile.badges"
                            :key="badge.id"
                        >
                            <Icon
                                :name="badge.icon"
                                class="col-start-1 row-span-2 row-start-1 h-full w-auto"
                            />
                            <h6 class="text-md text-white">
                                {{ badge.title }}
                            </h6>
                            <p class="text-md font-light">XXXXXX</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <h3
                        class="text-2xl font-light text-white/60"
                        v-if="$page.props.profile.username"
                    >
                        {{ $page.props.profile.username }}
                    </h3>
                    <h2 class="mb-8 text-3xl font-medium text-white">
                        {{ $page.props.profile.name }}
                    </h2>
                    <span class="flex flex-row gap-2">
                        <Icon name="fa-user" />
                        <p>
                            {{
                                $page.props.profile.profession ??
                                '(not specified)'
                            }}
                        </p>
                    </span>
                    <span
                        class="flex flex-row gap-2"
                        v-if="$page.props.profile.address"
                    >
                        <Icon name="hi-location-marker" />
                        <p>{{ $page.props.profile.address }}</p>
                    </span>
                    <span
                        class="flex flex-row gap-2"
                        v-if="$page.props.profile.created_at"
                    >
                        <Icon name="fa-regular-calendar-alt" />
                        <p>Joined {{ $page.props.profile.created_at }}</p>
                    </span>
                </div>
            </template>
        </Card>
        <Link :href="route('profile.edit')" class="my-4">
            <Button severity="contrast" class="align-self-end" outlined>
                Edit Profile
            </Button>
        </Link>
        <h1 class="align-self-start my-16 text-start text-5xl">
            Contributions
        </h1>
        <div class="grid w-full grid-cols-3 gap-4 lg:grid-cols-4">
            <Link
                v-for="room in $page.props.rooms"
                :key="room.id"
                :href="route('rooms.show', { room: room.id })"
            >
                <Card>
                    <template #content>
                        <img src="" alt="" class="aspect-[16/9] w-full" />
                        <Divider />
                        <h6 class="text-md text-white">Rank</h6>
                        <span
                            class="text-md flex flex-row items-center justify-between font-light text-white"
                        >
                            <p>X Tasks</p>
                            <p>Y Accepted</p>
                        </span>
                    </template>
                </Card>
            </Link>
        </div>
        <div class="h-16"></div>
    </MainLayout>
</template>

<style scoped></style>
