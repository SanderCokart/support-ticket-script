<template>
    <button type="button" :class="c({
    'enabled:hover:text-accent enabled:hover:underline': !!link,
    'p-0': !!noPadding,
    'px-4 py-2': !noPadding,
    'bg-transparent enabled:hover:text-accent': !!transparent,
    'bg-secondary enabled:hover:bg-accent': !transparent,
    },
    'text-xl font-bold rounded',
    'enabled:hover:scale-105 focus:scale-105 active:scale-90',
    'transition-all',
    'disabled:opacity-50 disabled:cursor-not-allowed',
    )">
        <slot/>
    </button>
</template>

<script setup lang="ts">
import c from 'classnames';

defineProps<{
    transparent?: boolean;
    link?: boolean;
    noPadding?: boolean;
}>();
</script>
