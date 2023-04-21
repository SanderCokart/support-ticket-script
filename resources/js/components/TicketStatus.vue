<template>
    <span class="flex whitespace-nowrap gap-2 font-medium" v-if="status?.title === 'Pending'">
        <IoTimer class="text-2xl text-warning"/>
        Pending
    </span>
    <span class="flex whitespace-nowrap gap-2 font-medium" v-else-if="status?.title === 'In Progress'">
        <IoSharpPlayForward class="text-2xl text-info"/>
        In Progress
    </span>
    <span class="flex whitespace-nowrap gap-2 font-medium" v-else-if="status?.title === 'Resolved'">
        <IoSharpCheckmarkCircle class="text-2xl text-success"/>
        Resolved
    </span>
</template>
<script setup lang="ts">
import type {StatusModel} from '@/types/model-types';
import {IoSharpCheckmarkCircle, IoSharpPlayForward, IoTimer} from '@kalimahapps/vue-icons';

defineProps<{
    status?: StatusModel;
    editable?: boolean;
}>();

</script>
