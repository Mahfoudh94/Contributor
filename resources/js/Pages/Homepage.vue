<script setup lang="ts">
import RoomItem from '@/Components/RoomItem.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Room } from '@/types/model';
import { Paginate } from '@7nohe/laravel-typegen';
import ArrowsUp from '@images/ArrowsUp.svg';
import ComputerBoy from '@images/HomepageMan.png';
import OurBenefitsImage from '@images/OurBenefitsImage.svg';
import Pattern from '@images/Pattern.svg';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
const rooms = usePage().props.rooms as Paginate<Room>;

const isTestimonialChoiceChanged = ref(false);
const isntTestimonialChoiceChanged = computed({
    get: () => !isTestimonialChoiceChanged.value,
    set: (val: boolean) => (isTestimonialChoiceChanged.value = !val),
});

defineOptions({
    layout: MainLayout,
});
</script>

<template>
    <div class="h-32"></div>
    <template v-if="$page.props.auth.user">
        <Card
            pt:content:class="!grid grid-cols-2"
            pt:body:class="relative overflow-hidden"
        >
            <template #content>
                <Card class="justify-self-center px-12">
                    <template #content>
                        <h1 class="my-2 text-6xl">Welcome to</h1>
                        <h1 class="my-2 text-6xl text-primary">Contributors</h1>
                        <p class="font-light text-white/60">
                            "Embark on your coding journey with a supportive
                            community by your side! Whether you're a beginner or
                            looking to level up, collaborating with others can
                            unlock new insights and accelerate your learning.
                            Open an account today and connect with like-minded
                            individuals ready to share knowledge, tackle
                            projects, and grow together."
                        </p>
                    </template>
                </Card>
                <img
                    :src="ComputerBoy"
                    alt="Computer boy"
                    class="z-10 rounded-md"
                />
                <img
                    :src="Pattern"
                    alt=""
                    class="absolute end-0 top-0 w-[200px]"
                />
            </template>
        </Card>
        <div class="h-32"></div>
        <div class="mb-4 flex w-full flex-row justify-between">
            <h1 class="text-4xl">Rooms</h1>
            <Link :href="route('rooms.create')">
                <Button>Create a room</Button>
            </Link>
        </div>
        <div
            class="grid w-full grid-cols-1 gap-x-8 gap-y-4 md:grid-cols-2 xl:grid-cols-3"
        >
            <RoomItem
                v-for="room in rooms.data"
                :key="room.id"
                :id="room.id"
                :title="room.title ?? 'it seems empty'"
                :description="room.description ?? 'it seems empty'"
                :tasks-count="room.tasks_count"
                :starts-at="room.start_at!"
            />
            <div class="h-32"></div>
        </div>
    </template>
    <template v-else>
        <div class="relative flex flex-col items-center">
            <h1 class="my-1 text-clip text-5xl font-medium text-white z-10">
                Juvdashavnothinpeelleskafbadudachechigaw
            </h1>
            <h1 class="my-1 text-clip text-4xl font-medium text-white z-10">
                Astauxtekalonshamilupvevuvenivanovafle
            </h1>
            <img
                class="absolute end-0 -translate-y-1/4 select-none"
                :src="ArrowsUp"
                alt=""
            />
        </div>
        <div class="h-16"></div>
        <InputGroup class="relative !max-w-md rounded-full">
            <InputText
                placeholder="What to search?"
                class="!rounded-full !px-8 !py-4 text-lg"
            />
            <Button
                label="Search"
                class="!absolute !end-2 !top-1/2 !z-10 h-[calc(100%-.75rem)] !-translate-y-1/2 !rounded-full"
            />
        </InputGroup>
        <div class="h-48"></div>
        <section class="flex w-full flex-col">
            <h1
                class="relative -start-4 mb-12 justify-self-start text-5xl font-bold"
            >
                <span class="text-white">Our </span>
                <span class="text-primary">Benefits</span>
            </h1>
            <div
                class="flex grid-cols-2 flex-col items-center justify-items-center gap-4 md:grid"
            >
                <div class="flex flex-col gap-4">
                    <Card
                        v-for="(_, index) in Array(3)"
                        :key="index"
                        pt:content:class="grid grid-cols-[auto_1fr] items-center gap-x-2"
                    >
                        <template #content>
                            <Icon name="fa-user" class="m-2 fill-primary" />
                            <p>
                                Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit. Asperiores consequuntur, eum
                                expedita in molestias quibusdam quisquam tempore
                                vel veniam voluptatem!
                            </p>
                        </template>
                    </Card>
                </div>
                <img
                    :src="OurBenefitsImage"
                    alt=""
                    class="col-start-2 justify-self-end"
                />
            </div>
        </section>
        <div class="h-48"></div>
        <section class="flex w-full flex-col">
            <h1
                class="relative -start-4 mb-12 justify-self-start text-5xl font-bold"
            >
                <span class="text-white">Feed</span>
                <span class="text-primary">Backs</span>
            </h1>
            <div class="flex w-full grid-cols-2 flex-col items-center md:grid">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Animi consequuntur ducimus harum, non possimus quam qui
                    quidem repudiandae suscipit voluptates. Distinctio
                    exercitationem itaque laboriosam odit suscipit tenetur
                    voluptate. Officiis, similique?
                </p>
                <div class="flex flex-row justify-center">
                    <ToggleButton
                        v-model="isTestimonialChoiceChanged"
                        onLabel="From contributors"
                        offLabel="From contributors"
                    />
                    <ToggleButton
                        v-model="isntTestimonialChoiceChanged"
                        onLabel="From Hosts"
                        offLabel="From Hosts"
                    />
                </div>
            </div>
            <div class="h-12"></div>
            <h4 class="my-4 text-2xl font-medium text-white justify-self-center text-center">
                There is no (enough) responses to show testimonials
            </h4>
        </section>
    </template>
    <div class="h-32"></div>
</template>

<style scoped>
.p-togglebutton {
    --p-togglebutton-content-checked-background: var(--p-primary-500);
    --p-togglebutton-checked-color: var(--p-surface-900);
}
</style>
