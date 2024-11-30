<script setup lang="ts">
import { ref } from 'vue';
import githubLogo from '@images/github-mark-white.png';
import { usePage } from "@inertiajs/vue3";

const isWindowActive = ref(false);
const openAuthWindow = () => {
    const width = 600;
    const height = 600;
    const left = (window.screen.width - width) / 2;
    const top = (window.screen.height - height) / 2;

    window.open(
        usePage().props.GITHUB_APP_INSTALLATION as string,
        'Authentication',
        `width=${width},height=${height},left=${left},top=${top}`,
    );
    isWindowActive.value = true;
    setTimeout(() => (isWindowActive.value = false), 2000);
};
</script>

<template>
    <Button severity="contrast" @click="openAuthWindow" :disabled="isWindowActive" outlined>
        <img :src="githubLogo" alt="" class="h-6" />
        Install
    </Button>
</template>

<style scoped>

</style>
