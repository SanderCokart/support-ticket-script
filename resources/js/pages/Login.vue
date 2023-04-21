<template>
    <div class="mx-auto grid min-h-screen place-items-center max-w-screen-xs">
        <Logo/>
        <form @submit.prevent="handleLogin" class="flex w-full flex-col gap-4 self-start">
            <h1 class="text-center title">Login</h1>
            <div>
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" v-model="state.email" id="email" placeholder="Your Email"
                       class="input-base">
                <FormError :errors="formErrors.email"/>
            </div>
            <div>
                <label for="password" class="sr-only">Password</label>
                <input type="password" v-model="state.password" name="password" id="password"
                       placeholder="Your Password"
                       class="input-base">
                <FormError :errors="formErrors.password"/>
            </div>
            <VButton type="submit">
                Login
            </VButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import {reactive, toRaw} from 'vue';
import injectStrict from '@/functions/injectStrict';
import {AxiosKey} from '@/plugins/symbols';
import type {LoginForm} from '@/types/form-types';
import type {FormError as FormErrorType} from '@/plugins/axios';
import FormError from '@/components/FormError.vue';
import type {LoginReturn} from '@/types/return-types';
import {useRouter} from 'vue-router';
import {useUserStore} from '@/stores/UserStore';
import Logo from '@/components/Logo.vue';
import VButton from '@/components/VButton.vue';

const axios = injectStrict(AxiosKey);
const userStore = useUserStore();
const router = useRouter();

const state = reactive<LoginForm>({
    email: '',
    password: ''
});

const formErrors = reactive<FormErrorType<LoginForm>>({});

const handleLogin = async () => {
    await axios.simplePost<LoginReturn, LoginForm>('/account/login', toRaw(state), {
        handleFormErrors: (errors) => {
            Object.assign(formErrors, errors);
        },
        handleSuccess: (data) => {
            userStore.setUser(data.user);
            userStore.setAccessToken(data.access_token);
            router.push({ name: 'dashboard' });
        }
    });
};

</script>
