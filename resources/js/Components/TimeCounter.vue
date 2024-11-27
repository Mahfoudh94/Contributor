<script setup lang="ts">
import moment from 'moment-timezone';
import { onMounted, ref } from 'vue';

const props = defineProps<{
    startTime: string;
}>();

const timerCount = ref(moment.utc().diff(moment.utc(props.startTime), 'seconds'));

onMounted(() =>
    setInterval(() => {
        timerCount.value += 1;
    }, 1000),
);
</script>

<template>
    <span class="flex flex-row font-mono text-xl font-medium" :class="$props.class">
        <p>{{ Math.floor(timerCount / 60) }}</p>:<p>{{ (timerCount % 60 + 100).toString().slice(1) }}</p>
    </span>
</template>

<style scoped></style>
