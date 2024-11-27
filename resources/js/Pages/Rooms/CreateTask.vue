<script setup lang="ts">
import { router, useForm } from "@inertiajs/vue3";
import { inject, ref } from 'vue';
const roomId = inject<string>('roomId');
const isDialogOpen = ref<boolean>(false);
const form = useForm<{
    title?: string;
    description?: string;
}>('Task/Create', {
    title: '',
    description: '',
});

const handleSubmit = async () => {
    router.post(
        route('tasks.store'),
        {
            roomId: roomId,
            title: form.title,
            description: form.description,
        },
        {
            onSuccess: () => {
                isDialogOpen.value = false;
                form.reset();
            },
            only: [],
        },
    );
};

const openModal = () => (isDialogOpen.value = true);
defineExpose({
    openModal,
});
</script>

<template>
    <Dialog v-model:visible="isDialogOpen" class="w-full max-w-screen-md">
        <template #header>
            <h1 class="text-xl font-medium">Add task</h1>
        </template>
        <h4 class="font-bold">Title:</h4>
        <InputText v-model="form.title" class="my-2 w-full" />
        <h4 class="font-bold">Description:</h4>
        <TextArea v-model="form.description" rows="7" class="my-2 w-full" />
        <template #footer>
            <Button class="align-self-end" @click="handleSubmit">
                Submit
            </Button>
        </template>
    </Dialog>
</template>

<style scoped></style>
