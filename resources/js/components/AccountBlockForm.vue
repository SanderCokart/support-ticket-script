<template>
    <div class="bg-primaryLight border-accent border-2 rounded-lg">
        <form v-bind="$attrs" class="h-full grid content-start p-8 gap-8">
            <slot/>
        </form>
    </div>
</template>
