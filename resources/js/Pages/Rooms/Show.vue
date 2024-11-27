<script setup lang="ts">
import TimeCounter from '@/Components/TimeCounter.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import CreateTask from '@/Pages/Rooms/CreateTask.vue';
import EditTask from '@/Pages/Rooms/EditTask.vue';
import { Room, Task, TaskStatusEnum } from '@/types/model';
import { router } from '@inertiajs/vue3';
import { provide, ref } from 'vue';
const createTaskRef = ref();
const editTaskRef = ref();
const editableTask = ref({});
const props = defineProps<{
    room: Room;
}>();
const taskStatusColorizer = {
    0: '!bg-blue-500',
    1: '!bg-green-500',
    2: '!bg-yellow-500',
    3: '!bg-red-500/40',
};
provide('roomId', props.room.id);
const openCreateTaskDialog = () => createTaskRef.value!.openModal();
const openEditTaskDialog = () => editTaskRef.value!.openModal();

const startTaskServerCall = (taskId: string) => {
    router.patch(route('tasks.start', { task: taskId }), undefined, {
        only: [],
    });
};
const joinTaskServerCall = (taskId: string) => {
    router.post(route('tasks.join', { task: taskId }), undefined, {
        only: [],
    });
};

defineOptions({
    layout: MainLayout,
});
</script>

<template>
    <Tabs value="overview" class="w-full">
        <div class="flex flex-row items-center justify-between">
            <TabList class="!bg-transparent" pt:TabList:class="!bg-transparent">
                <Tab value="overview">Overview</Tab>
                <Tab value="tasks">Tasks</Tab>
                <Tab value="qna">Q&A</Tab>
            </TabList>
            <Button
                v-if="$page.props.auth.user?.id == room.manager_id"
                @click="openCreateTaskDialog"
                outlined
            >
                Add a task
            </Button>
        </div>
        <TabPanels class="!bg-transparent">
            <TabPanel value="overview">
                <Card
                    class="my-4 px-4 py-4"
                    v-if="$page.props.auth.user?.id == room.manager_id"
                >
                    <template #header>
                        <h4 class="text-2xl font-bold">
                            Github repository informations
                        </h4>
                    </template>
                    <template #content>
                        <span class="flex flex-row gap-2">
                            <h6 class="text-md font-medium text-white">
                                Owner:
                            </h6>
                            <p class="text-white/60">
                                {{ room.repository?.owner }}
                            </p>
                        </span>
                        <span class="flex flex-row gap-2">
                            <h6 class="text-md font-medium text-white">
                                Repository:
                            </h6>
                            <p class="text-white/60">
                                {{ room.repository?.repository }}
                            </p>
                        </span>
                        <span class="flex flex-row gap-2">
                            <h6 class="text-md font-medium text-white">
                                Base branch:
                            </h6>
                            <p class="text-white/60">
                                {{ room.repository?.branch }}
                            </p>
                        </span>
                    </template>
                </Card>
                <Card class="my-4 px-4 py-4">
                    <template #header>
                        <h4 class="text-2xl font-bold">Description</h4>
                    </template>
                    <template #content>
                        <p
                            :class="[
                                room.description
                                    ? 'text-white'
                                    : 'text-center text-white/60',
                            ]"
                        >
                            {{ room.description ?? '(It seems empty...)' }}
                        </p>
                    </template>
                </Card>
                <Card class="my-4 px-4 py-4">
                    <template #header>
                        <h4 class="text-2xl font-bold">Tasks</h4>
                    </template>
                    <template #content>
                        <ol class="list-decimal" v-if="room.tasks_count > 0">
                            <li
                                v-for="task in room.tasks"
                                :key="task.id"
                                :class="[task.title ? '' : 'text-white/60']"
                            >
                                {{ task.title || 'empty' }}
                            </li>
                        </ol>
                        <p class="text-center text-white/60" v-else>
                            (No tasks to see for now)
                        </p>
                    </template>
                </Card>
            </TabPanel>
            <TabPanel value="tasks">
                <div
                    class="mx-12 my-4 flex max-w-screen-xl flex-col items-center gap-y-4"
                >
                    <Panel
                        v-for="(task, taskIndex) in $props.room.tasks"
                        :key="task.id"
                        class="w-full border !border-lime-500/20"
                        pt:header-actions:class="flex flex-row items-center"
                        collapsed
                        toggleable
                    >
                        <template #header>
                            <div
                                class="my-1 flex flex-row items-center gap-x-8"
                            >
                                <h1 class="text-xl text-amber-500">
                                    <span class="!font-black">
                                        Task {{ taskIndex + 1 }}:
                                    </span>
                                    &nbsp; {{ task.title }}
                                </h1>
                                <Chip
                                    class="scale-75 !font-bold !text-black"
                                    :class="taskStatusColorizer[task.status]"
                                >
                                    {{ TaskStatusEnum[task.status] }}
                                </Chip>
                            </div>
                        </template>
                        <template
                            #icons
                            v-if="$page.props.auth.user?.id == room.manager_id"
                        >
                            <Button
                                class="me-2 text-sm !text-white hover:!bg-amber-500/5"
                                v-if="task.status == TaskStatusEnum.Planned"
                                @click="startTaskServerCall(task.id)"
                                text
                            >
                                Start task
                            </Button>
                            <TimeCounter
                                class="me-4 text-sm !text-white"
                                v-if="task.status == TaskStatusEnum.Active"
                                :start-time="task.start_at"
                            />
                            <Button
                                class="aspect-square !text-amber-500 hover:!bg-amber-500/5"
                                severity="contrast"
                                @click="
                                    editableTask = { ...task } as Task;
                                    openEditTaskDialog();
                                "
                                text
                                rounded
                            >
                                <Icon name="hi-solid-pencil" />
                            </Button>
                        </template>
                        <template #icons v-else>
                            <Button
                                class="me-4 !bg-amber-500/5 text-sm !text-amber-500"
                                :class="[
                                    task.is_joined
                                        ? ''
                                        : 'hover:!bg-amber-500/20',
                                ]"
                                v-if="
                                    !!$page.props.auth.user &&
                                    task.status == TaskStatusEnum.Active
                                "
                                :disabled="task.is_joined"
                                @click="joinTaskServerCall(task.id)"
                                text
                            >
                                {{ task.is_joined ? 'Joined' : 'Join Task' }}
                            </Button>
                            <TimeCounter
                                class="me-4 text-sm !text-white"
                                v-if="task.status == TaskStatusEnum.Active"
                                :start-time="task.start_at"
                            />
                        </template>
                        <p
                            :class="
                                !task.description && 'text-center text-white/40'
                            "
                        >
                            {{ task.description ?? '(none to be found)' }}
                        </p>
                    </Panel>
                </div>
            </TabPanel>
        </TabPanels>
    </Tabs>
    <CreateTask :room-id="$props.room.id" ref="createTaskRef" />
    <EditTask :task="editableTask" ref="editTaskRef" />
</template>

<style scoped></style>
