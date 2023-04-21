<template>
    <AuthenticatedLayout v-if="isLoggedIn">
        <RouterView></RouterView>
    </AuthenticatedLayout>


    <GuestLayout v-else>
        <RouterView></RouterView>
    </GuestLayout>
</template>
<script setup>
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import {useUserStore} from '@/stores/UserStore';
import {storeToRefs} from 'pinia';

const {isLoggedIn, user} = storeToRefs(useUserStore());
</script>
