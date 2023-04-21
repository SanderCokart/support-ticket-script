<template>
    <div class="flex gap-2">
        <VButton @click="handleViewChange('grid')" no-padding transparent class="hover:text-accent" :class="{
            'text-accent': view === 'grid'
        }">
            <BsGrid3x3GapFill class="text-3xl"/>
        </VButton>
        <VButton transparent no-padding @click="handleViewChange('list')" class="hover:text-accent" :class="{
            'text-accent': view === 'list'
        }">
            <FaList class="text-3xl"/>
        </VButton>
        <VButton transparent no-padding @click="handleViewChange('table')" :class="{
            'text-accent': view === 'table'
        }">
            <FaTable class="text-3xl"/>
        </VButton>
    </div>
</template>
<script setup lang="ts">
import {BsGrid3x3GapFill, FaList, FaTable} from '@kalimahapps/vue-icons';
import type {View} from '@/types/param-types';
import {ref} from 'vue';
import VButton from '@/components/VButton.vue';

const props = defineProps<{ default?: View; }>();
const view = ref<View>(props.default ?? 'list');

const emit = defineEmits<{ (e: 'onViewChange', view: View): void; }>();

const handleViewChange = (newView: View) => {
    view.value = newView;
    emit('onViewChange', newView);
};
</script>

