<script setup lang="ts">
import GithubButton from '@/Components/GithubButton.vue';
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
const benefits = [
    {
        icon: 'fa-user',
        text: 'Collaborate seamlessly with talented individuals from around the globe, fostering innovation and diverse perspectives.'
    },
    {
        icon: 'fa-lightbulb',
        text: 'Enhance your skills by working on real-world projects, gaining experience, and building a portfolio that stands out.'
    },
    {
        icon: 'fa-trophy',
        text: 'Get recognized for your contributions with awards and accolades that demonstrate your expertise and value.'
    }
];

defineOptions({
    layout: MainLayout
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
            <span class="flex flex-row gap-4">
                <Link
                    :href="route('rooms.create')"
                    :disabled="
                        !$page.props.auth.user!.github_account?.installation_id
                    "
                >
                    <Button :disabled="!$page.props.auth.user!.github_account?.installation_id">
                        Create a room
                    </Button>
                </Link>
                <GithubButton
                    v-if="!$page.props.auth.user!.github_account?.installation_id"
                />
            </span>
        </div>
        <div
            class="grid w-full grid-cols-1 gap-x-8 gap-y-4 md:grid-cols-2 xl:grid-cols-3"
        >
            <RoomItem v-for="room in rooms.data" :key="room.id" :room="room" />
            <!--                :id="room.id"-->
            <!--                :title="room.title ?? 'it seems empty'"-->
            <!--                :description="room.description ?? 'it seems empty'"-->
            <!--                :tasks-count="room.tasks_count"-->
            <!--                :starts-at="room.start_at!"-->
            <!--                :status="room.tasks?.reduce()"-->
            <div class="h-32"></div>
        </div>
    </template>
    <template v-else>
        <div class="relative flex flex-col items-center">
            <h1 class="z-10 my-1 text-clip text-5xl font-medium text-white">
                Where Ideas Meet Innovation
            </h1>
            <h1 class="z-10 my-1 text-clip text-4xl font-medium text-white">
                Let Curiosity Lead the Way
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
                        v-for="(benefit, index) in benefits"
                        :key="index"
                        pt:content:class="grid grid-cols-[auto_1fr] items-center gap-x-2"
                    >
                        <template #content>
                            <Icon :name="benefit.icon" class="m-2 fill-primary" />
                            <p>{{ benefit.text }}</p>
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
                    Your voice matters. Every feedback helps us refine,
                    innovate, and create a platform that empowers everyone to achieve their goals.
                    Together, we grow stronger.
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
<!--            <h4
                class="my-4 justify-self-center text-center text-2xl font-medium text-white"
            >
                There is no (enough) responses to show testimonials
            </h4>-->
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
