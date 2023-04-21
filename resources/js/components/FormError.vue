<template>
    <div v-if="errors" class="w-fit rounded-lg bg-white px-2 py-1 text-sm font-black text-error empty:hidden">{{ errors.join('\n') }}</div>
</template>


<script setup lang="ts">
const props = defineProps({
    errors: {
        type: Array<string>
    }
});
</script>
