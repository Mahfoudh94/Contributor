<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import moment from 'moment';
import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';
import axios from "axios";

const form = useForm<{
    repository?: string;
    branch: string;
    title?: string;
    description?: string;
    start_at?: Date | null;
    // repository goes here
}>('Room/Create', {
    repository: '',
    branch: '',
    title: '',
    description: '',
    start_at: null,
});

const toast = useToast();
const repositories = usePage().props.repositories.data as unknown[];
const branches = ref(); // usePage().props.branches.data as unknown[];
const isLoadingBranches = ref(false);
// const fileUploadRef = ref();
const submit = () => {
    if ((form.title?.length ?? 0) < 6) {
        toast.add({
            severity: 'error',
            summary: 'Invalid room data',
            detail: 'Title has to be 6 characters or more',
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

const loadBranches = async () => {
    isLoadingBranches.value = true;
    form.reset('branch');
    const { data } = await axios.get(
        route('getBranches', {repo: form.repository}),
    );
    branches.value = data.data as object[];
    isLoadingBranches.value = false;
};
</script>

<template>
    <MainLayout>
        <div class="mx-12 w-full max-w-screen-lg">
            <h1 class="mt-8 text-4xl font-light text-white">Create a room</h1>
            <p class="text-md mb-8 mt-2">
                Here you create a room to be published to CONTRIBUTORS all
                around the globe (and even out of it for some reason) to take
                part in development.
            </p>
        </div>
        <div class="h-12"></div>
        <form
            class="mx-12 flex w-full max-w-screen-lg flex-col items-center gap-y-4"
            @submit.prevent="submit"
        >
            <span class="flex w-full flex-col items-center gap-4 md:flex-row">
                <Select
                    v-model="form.repository"
                    :options="repositories"
                    optionLabel="name"
                    optionValue="name"
                    placeholder="Select a repository"
                    @change="loadBranches"
                    fluid
                />
                <p class="hidden scale-[250%] text-xl font-light md:block">\</p>
                <Select
                    v-model="form.branch"
                    :options="branches"
                    optionLabel="name"
                    optionValue="name"
                    :disabled="!form.repository || isLoadingBranches"
                    fluid
                />
                <Icon name="fa-spinner" animation="spin-pulse" v-if="isLoadingBranches" />
                <!--                <InputText-->
                <!--                    v-model="form.branch"-->
                <!--                    placeholder="Branch name"-->
                <!--                    :disable="!form.repository"-->
                <!--                />-->
            </span>
            <InputText
                v-model="form.title"
                class="w-full"
                size="large"
                placeholder="Room's Title"
            />
            <Textarea
                v-model="form.description"
                class="w-full"
                size="large"
                placeholder="Room's description"
                rows="5"
            />
            <DatePicker
                v-model="form.start_at"
                :invalid="moment(form.start_at).diff(moment(), 'minutes') < -1"
                showTime
                showIcon
                hourFormat="24"
                iconDisplay="input"
                placeholder="Start time (optional)"
                :minDate="moment().toDate()"
                fluid
            />
            <!--            <FileUpload-->
            <!--                ref="fileUploadRef"-->
            <!--                accept="image/*,pdf/*"-->
            <!--                pt:root:class="!bg-primary-800/5 text-center"-->
            <!--                @upload="console.log($event)"-->
            <!--            >-->
            <!--                <template #content="{ files, removeFileCallback }">-->
            <!--                    <template v-if="files.length > 0">-->
            <!--                        <p>There is an upload</p>-->
            <!--                        <Button-->
            <!--                            @click="removeFileCallback(0)"-->
            <!--                            severity="contrast"-->
            <!--                            text-->
            <!--                            class="text-red-500"-->
            <!--                            >X</Button-->
            <!--                        >-->
            <!--                    </template>-->
            <!--                    <template v-else>-->
            <!--                        <Icon-->
            <!--                            name="hi-cloud-upload"-->
            <!--                            class="mx-8 my-4"-->
            <!--                            scale="5"-->
            <!--                        />-->
            <!--                        <h5 class="mb-3 text-2xl font-extrabold">-->
            <!--                            Drag & Drop-->
            <!--                        </h5>-->
            <!--                        <h6 class="text-md font-lighter">-->
            <!--                            Upload a file to be added to the room-->
            <!--                        </h6>-->
            <!--                    </template>-->
            <!--                </template>-->
            <!--            </FileUpload>-->
            <div class="my-8 flex w-full justify-end">
                <Button type="submit"> Create </Button>
            </div>
        </form>
    </MainLayout>
</template>

<style scoped></style>
