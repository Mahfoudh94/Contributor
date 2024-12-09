<script setup lang="ts">
import { Room, Task, TaskStatusEnum } from '@/types/model';
import { Link } from '@inertiajs/vue3';
import moment from 'moment/moment';
import { computed, ref } from 'vue';

const props = defineProps<{
    room: Room;
    // id: string;
    // startsAt: string;
    // tasksCount: number;
    // title?: string;
    // description?: string;
    canJoin?: {
        type: Boolean;
        default: false;
    };
    // canEdit?: boolean;
}>();
const isStartedAlready = ref(
    moment(props.room.start_at, 'MM/DD HH:mm').diff(moment(), 'minutes'),
);
const imageParent = ref();
const computedRoomStatus = computed(
    () =>
        props.room.tasks?.reduce<number>(
            (prev, curr: Task) => Math.max(prev, curr.status),
            0,
        ) as unknown,
);

const roomStatusColorizer = {
    0: '!bg-blue-500',
    1: '!bg-pink-500',
    2: '!bg-yellow-500',
    3: '!bg-red-500/40',
};
</script>

<template>
    <Card
        pt:root:class="!w-full relative !overflow-hidden"
        pt:header:class="!flex flex-row flex-wrap gap-2 px-4 pt-4 mt-2"
        pt:content:class="!grid grid-cols-[2fr_1fr] gap-x-2"
        pt:footer:class="!flex flex-row justify-between items-center"
    >
        <template #header>
            <Chip
                class="text-md start-0 top-0 !w-full justify-center border border-surface-100/10 !py-1.5"
                :class="[roomStatusColorizer[computedRoomStatus as number]]"
            >
                {{ TaskStatusEnum[computedRoomStatus as number] }}
            </Chip>
            <Chip class="border border-surface-100/20 !bg-surface-950">
                <p class="text-sm text-white/60">
                    {{ isStartedAlready ? 'Started' : 'Starts' }} at:&nbsp;
                </p>
                <p class="text-sm font-light text-white/60">
                    {{ $props.room.start_at ?? 'Unknown' }}
                </p>
            </Chip>
            <Chip class="border-2 border-primary-400/20 !bg-surface-950">
                <p class="text-sm font-bold text-white/60">Tasks:&nbsp;</p>
                <p class="text-sm text-white/60">
                    {{ $props.room.tasks_count }}
                </p>
            </Chip>
            <!--            <Chip>-->
            <!--                <p class="text-sm font-bold">Starts at:&nbsp;</p>-->
            <!--                <p class="text-sm">{{ $props.startsAt }}</p>-->
            <!--            </Chip>-->
        </template>
        <template #content>
            <div>
                <h1 class="mb-2 text-sm font-medium text-primary-200">
                    {{ $props.room.title }}
                </h1>
                <p class="text-sm font-thin">{{ $props.room.description }}</p>
            </div>
            <div
                class="aspect-square overflow-hidden text-center"
                ref="imageParent"
            >
                <img
                    class="h-full w-full rounded-full bg-black object-cover"
                    :src="$props.room.manager?.profile_picture_url"
                    alt=" "
                />
            </div>
        </template>
        <template #footer>
            <Link href="">
                <Button :disabled="!isStartedAlready || !$props.canJoin">
                    {{
                        isStartedAlready && $props.canJoin
                            ? 'Join Now'
                            : 'Join Unavailable'
                    }}
                </Button>
            </Link>
            <Link :href="route('rooms.show', { id: $props.room.id })">
                <Button severity="secondary" text>
                    Details
                    <Icon name="fa-arrow-right" class="fill-primary" />
                </Button>
            </Link>
        </template>
    </Card>
</template>

<style scoped></style>
