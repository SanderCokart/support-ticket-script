<template>
    <VSpacing>
        <div class="grid grid-cols-2">
            <slot name="search"/>
            <div class="flex gap-4 col-start-2 place-self-end">
                <ViewSelector :default="view" @onViewChange="handleViewChange"/>
                <slot name="header-actions"/>
            </div>
        </div>

        <!-- List View -->
        <ul v-if="view === 'list'" class="max-w-none prose prose-sm prose-invert flex-col flex gap-2">
            <slot name="list"/>
        </ul>


        <!-- Grid View -->
        <ul v-else-if="view === 'grid'"
            class="grid max-w-none gap-4 prose prose-sm prose-invert grid-cols-fit-[450px]">
            <slot name="grid"/>
        </ul>

        <table v-else-if="view === 'table'">
            <slot name="table"/>
        </table>

        <slot/>

    </VSpacing>
</template>

<script setup lang="ts">
import ViewSelector from '@/components/ViewSelector.vue';
import {useLocalStorage} from '@vueuse/core';
import {View} from '@/types/param-types';
import VSpacing from '@/components/VSpacing.vue';

const view = useLocalStorage('view-preference', 'list');

const handleViewChange = (newView: View) => {
    view.value = newView;
};
</script>

<style scoped>

</style>
