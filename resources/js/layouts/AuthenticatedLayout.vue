<template>
    <div class="flex w-full items-center justify-between border-b-4 p-4 h-[76px] bg-secondary border-accent">
        <RouterLink class="hover:text-accent transition-colors" :to="{name:'dashboard'}">
            <Logo/>
        </RouterLink>
        <div class="flex items-center text-xl font-bold">
            <VButton transparent link @click="router.push({name:'tickets-index'})">
                {{ user?.is_admin ? 'Tickets' : 'My Tickets' }}
            </VButton>
            <VButton transparent link @click="handleLogout">Logout</VButton>
            <VButton transparent link @click="router.push({name:'account'})">
                {{ user?.full_name }}
            </VButton>
        </div>
    </div>
    <slot/>
</template>

<script setup lang="ts">
import Logo from '@/components/Logo.vue';
import {useRouter} from 'vue-router';
import {useAxios} from '@/plugins/axios';
import {useUserStore} from '@/stores/UserStore';
import VButton from '@/components/VButton.vue';
import {toRefs} from 'vue';

const router = useRouter();
const axios = useAxios();
const userStore = useUserStore();
const { user } = toRefs(userStore);

const handleLogout = async () => {
    await userStore.logout();
    router.push({ name: 'login' });
};
</script>
