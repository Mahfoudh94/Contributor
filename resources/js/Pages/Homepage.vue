<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import ComputerBoy from '@images/HomepageMan.png';
import Pattern from '@images/Pattern.svg';
</script>

<template>
    <MainLayout>
        <div class="h-32"></div>
        <template v-if="$page.props.auth.user">
            <Card pt:content:class="!grid grid-cols-2" pt:body:class="relative overflow-hidden">
                <template #content>
                    <Card class="justify-self-center px-12">
                        <template #content>
                            <h1 class="my-2 text-6xl">Welcome to</h1>
                            <h1 class="my-2 text-6xl text-primary">
                                Contributors
                            </h1>
                            <p class="font-light text-white/60">
                                "Embark on your coding journey with a supportive
                                community by your side! Whether you're a
                                beginner or looking to level up, collaborating
                                with others can unlock new insights and
                                accelerate your learning. Open an account today
                                and connect with like-minded individuals ready
                                to share knowledge, tackle projects, and grow
                                together."
                            </p>
                        </template>
                    </Card>
                    <img :src="ComputerBoy" alt="Computer boy" class="rounded-md z-10" />
                    <img :src="Pattern" alt="" class="absolute w-[200px] end-0 top-0" />
                </template>
            </Card>
        </template>
        <template v-else>
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
        </template>
        <div class="h-32"></div>
    </MainLayout>
</template>

<style scoped>

</style>
