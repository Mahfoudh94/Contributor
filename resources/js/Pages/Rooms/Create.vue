<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3';
import moment from 'moment';
import { useToast } from 'primevue/usetoast';

const form = useForm<{
    title?: string;
    description?: string;
    start_at?: Date;
    // repository goes here
}>('Room/Create', {
    title: '',
    description: '',
});

const toast = useToast();

const submit = () => {
    if ((form.title?.length ?? 0) < 6 || (form.description?.length ?? 0) < 6) {
        toast.add({
            severity: 'error',
            summary: 'Invalid room data',
            detail:
                (form.title ?? '').length < 6
                    ? 'Title has to be 6 characters or more'
                    : 'Description has to be 6 characters or more',
            life: 3000,
        });
        return;
    }
    form.post(route('rooms.store'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <MainLayout>
        <form
            class="mx-12 flex w-full max-w-screen-lg flex-col items-center"
            @submit.prevent="submit"
        >
            <h1 class="my-8 text-4xl font-bold">Create a room</h1>
            <div
                class="flex w-full grid-cols-[auto_1fr] flex-col items-start gap-4 md:grid"
            >
                <label for="title" class="font-bold">Title</label>
                <InputText
                    v-model="form.title"
                    size="large"
                    pt:root:class="w-full"
                />
                <label for="title" class="font-bold">Description</label>
                <Textarea
                    v-model="form.description"
                    size="large"
                    pt:root:class="w-full"
                />
                <label for="title" class="font-bold">Start time</label>
                <DatePicker
                    class="w-full"
                    v-model="form.start_at"
                    :invalid="
                        moment(form.start_at).diff(moment(), 'minutes') < -1
                    "
                    showTime
                    showIcon
                    hourFormat="24"
                    iconDisplay="input"
                    :minDate="moment().toDate()"
                />
                <!--      Repository selector here using <Select />          -->
            </div>
            <div class="my-8 flex w-full justify-end">
                <Button rounded type="submit" size="large"> Create </Button>
            </div>
        </form>
    </MainLayout>
</template>

<style scoped></style>
