<script setup lang="ts">
import AuthPagesLayout from '@/Layouts/AuthPagesLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('register'), {
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
    <Head title="Register to Contributors" />
    <h1 class="my-2 text-5xl font-bold">
        Create new account
        <span class="text-primary">.</span>
    </h1>
    <p class="pb-8 text-white/60">
        Already having an account?
        <Link
            :href="route('login')"
            class="border-b border-b-primary/0 pb-0.5 text-primary transition duration-200 hover:border-b-primary"
            replace
        >
            Log in
        </Link>
    </p>
    <form @submit.prevent="submit" class="flex flex-col gap-8">
        <div class="flex w-full flex-row gap-8">
            <FloatLabel variant="on">
                <InputText
                    v-model="form.firstName"
                    id="firstName"
                    size="large"
                    class="w-full !bg-surface-900 !px-8"
                    autofocus
                />
                <label for="firstName">First Name</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    v-model="form.lastName"
                    id="lastName"
                    size="large"
                    class="w-full !bg-surface-900 !px-8"
                />
                <label for="lastName">Last Name</label>
            </FloatLabel>
        </div>
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
                type="password"
            />
            <label for="password">Password</label>
        </FloatLabel>

        <div
            class="flex flex-shrink-0 flex-row items-center justify-end gap-2 px-4"
        >
            <Checkbox v-model="form.remember" />
            <label class="me-auto">Remember me.</label>
            <Button size="large" type="submit"> Create account </Button>
            <Divider layout="vertical" pt:content:class="font-bold">
                OR
            </Divider>
            <Link :href="route('auth.github')">
                <Button size="large" outlined> Sign in with GitHub </Button>
            </Link>
        </div>
        <p class="w-full text-center">
            By creating an account, you agree to our
            <Link
                :href="route('_tos')"
                class="border-b border-b-primary/0 pb-0.5 text-primary transition duration-200 hover:border-b-primary"
            >
                terms of service.
            </Link>
        </p>
    </form>
</template>
