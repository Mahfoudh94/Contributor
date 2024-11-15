<script setup lang="ts">
import { Task } from '@/types/model';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
const _isDialogOpen = ref<boolean>(false);
const isDeleteOpen = ref<boolean>(false);
const isDialogOpen = computed({
    get: () => _isDialogOpen.value && !isDeleteOpen.value,
    set: (val: boolean) => (_isDialogOpen.value = val),
});
const isDeleting = ref<boolean>(false);

const props = defineProps<{
    task: Task;
}>();

const handleSubmit = async () => {
    router.put(
        route('tasks.update', { id: props.task!.id }),
        {
            title: props.task!.title,
            description: props.task!.description,
        },
        {
            onSuccess: () => (isDialogOpen.value = false),
            only: [],
        },
    );
};
const deleteTask = async () => {
    isDeleting.value = true;
    router.delete(route('tasks.destroy', { id: props.task!.id }), {
        only: [],
    });
    isDeleting.value = false;
};

const openModal = () => (isDialogOpen.value = true);
defineExpose({
    openModal,
});
</script>

<template>
    <Dialog v-model:visible="isDialogOpen" class="w-full max-w-screen-md" modal>
        <template #header>
            <h1 class="text-xl font-medium">Add task</h1>
        </template>
        <h4 class="font-bold">Title:</h4>
        <InputText v-model="$props.task.title" class="my-2 w-full" />
        <h4 class="font-bold">Description:</h4>
        <TextArea
            v-model="$props.task.description"
            rows="7"
            class="my-2 w-full"
        />
        <template #footer>
            <Button severity="danger" @click="isDeleteOpen = true" text>
                <Icon name="hi-trash" />
                <h6>Delete</h6>
            </Button>
            <Button class="align-self-end" @click="handleSubmit">
                Submit
            </Button>
        </template>
    </Dialog>
    <Dialog v-model:visible="isDeleteOpen" modal>
        <template #header>
            <h1 class="text-xl font-medium">Delete task</h1>
        </template>
        <p>
            Are you surer that you want to delete this task:
            <span
                :class="
                    $props.task.title
                        ? 'font-medium'
                        : 'font-light text-white/60'
                "
            >
                {{ $props.task.title ?? '(no title)' }}
            </span>
            ?
        </p>
        <template #footer>
            <Button severity="contrast" @click="isDeleteOpen = false" outlined>
                Cancel
            </Button>
            <Button
                severity="danger"
                @click="deleteTask"
                :disabled="isDeleting"
            >
                Delete
            </Button>
        </template>
    </Dialog>
</template>

<style scoped></style>
