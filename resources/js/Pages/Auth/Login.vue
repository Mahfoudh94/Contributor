<script setup lang="ts">
import AuthPagesLayout from '@/Layouts/AuthPagesLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Divider from 'primevue/divider';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};

defineOptions({
    layout: AuthPagesLayout,
});
</script>

<template>
    <Head title="Sign in to Contributors" />
    <h1 class="my-2 text-5xl font-bold">
        Sign in
        <span class="text-primary">.</span>
    </h1>
    <p class="pb-8 text-white/60">
        Not a member already?
        <Link
            :href="route('register')"
            class="border-b border-b-primary/0 pb-0.5 text-primary transition duration-200 hover:border-b-primary"
            replace
        >
            Register
        </Link>
    </p>
    <form @submit.prevent="submit" class="flex flex-col gap-8">
        <FloatLabel variant="on">
            <InputText
                v-model="form.email"
                id="email"
                size="large"
                class="w-full !bg-surface-900 !px-8"
            />
            <label for="email">Email</label>
        </FloatLabel>
        <FloatLabel variant="on">
            <InputText
                v-model="form.password"
                id="password"
                size="large"
                class="w-full !bg-surface-900 !px-8"
            />
            <label for="password">Password</label>
        </FloatLabel>

        <div
            class="flex flex-shrink-0 flex-row items-center justify-end gap-2 px-4"
        >
            <Checkbox v-model="form.remember" />
            <label class="me-auto">Remember me.</label>
            <Button size="large" type="submit"> Login </Button>
            <Divider layout="vertical" pt:content:class="font-bold">
                OR
            </Divider>
            <Link :href="route('auth.github')">
                <Button size="large" outlined> Sign in with GitHub </Button>
            </Link>
        </div>
    </form>
</template>
