<script setup lang="ts">
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const fileUploadRef = ref();
const files = computed(() => fileUploadRef.value?.files ?? []);
const userInfos = ref({
    description: null,
});

const deleteFile = (index: number) =>
    (fileUploadRef.value.files = fileUploadRef.value.files.filter(
        (_: unknown, i: number) => index !== i,
    ));
</script>

<template>
    <div class="my-8 flex items-center justify-between px-6">
        <h1 class="text-4xl font-bold">Edit Profile</h1>
        <Link :href="route('Homepage')">
            <Button text variant="contrast" class="aspect-square !rounded-full">
                <Icon name="hi-solid-x" />
            </Button>
        </Link>
    </div>
    <div class="mx-12 my-4 flex grid-cols-2 flex-col items-center md:grid">
        <div class="flex flex-col items-center gap-2">
            <FileUpload
                ref="fileUploadRef"
                accept="image/*,pdf/*"
                pt:root:class="!bg-primary-800/5 text-center"
                @upload="console.log($event)"
                multiple
            >
                <template #content>
                    <Icon name="hi-cloud-upload" class="mx-8 my-4" scale="5" />
                    <h5 class="mb-3 text-2xl font-extrabold">Drag & Drop</h5>
                    <h6 class="text-md font-lighter">
                        Upload a file to be added to your profile
                    </h6>
                </template>
            </FileUpload>
            <Panel
                v-for="(file, fileIndex) in files"
                :key="file.filename"
                class="w-4/5"
                pt:content:class="grid grid-cols-[1fr_2fr_2rem] gap-x-4 my-2 items-center *:min-w-0"
            >
                <img
                    :src="file.objectURL"
                    alt=""
                    class="col-start-1 max-h-full max-w-full"
                />
                <p class="col-start-2">{{ file.name }}</p>
                <Button
                    @click="() => deleteFile(fileIndex)"
                    class="col-start-3 aspect-square rounded-full"
                    variant="secondary"
                    text
                >
                    <Icon name="hi-solid-x" class="fill-red-500" />
                </Button>
            </Panel>
        </div>
        <Tabs value="info" class="h-full">
            <TabList class="!bg-transparent" pt:TabList:class="!bg-transparent">
                <Tab value="info">Infos</Tab>
                <Tab value="description">Description</Tab>
            </TabList>
            <TabPanels class="!bg-transparent">
                <TabPanel value="info"> </TabPanel>
                <TabPanel value="description">
                    <Textarea
                        v-model="userInfos.description"
                        class="w-full"
                        placeholder="Write a brief bio about yourself"
                        rows="10"
                    />
                </TabPanel>
            </TabPanels>
        </Tabs>
    </div>
</template>
