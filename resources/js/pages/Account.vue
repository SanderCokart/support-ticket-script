<template>
    <div class="min-h-desktop grid grid-cols-fit-[350px] items-stretch p-8 lg:p-32 gap-8">
        <AccountBlockForm @submit.prevent.stop="updateEmail">
            <h1 class="title">Email</h1>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="email">Email</label>
                <input type="email" id="email" class="input-base" placeholder="Enter your email"
                       v-model="updateEmailForm.form.email">
                <FormError :errors="updateEmailForm.errors.email"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="update-email-password">Password</label>
                <input type="password" id="update-email-password" class="input-base" placeholder="Enter your password"
                       v-model="updateEmailForm.form.password">
                <FormError :errors="updateEmailForm.errors.password"/>
            </div>
            <VButton type="submit" class="place-self-center">Update email</VButton>
        </AccountBlockForm>
        <AccountBlockForm @submit.prevent.stop="updatePassword">
            <h1 class="title">Password</h1>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="current-password">Password</label>
                <input v-model="updatePasswordForm.form.current_password" name="current-password" type="password"
                       id="current-password" class="input-base"
                       placeholder="Enter your password">
                <FormError :errors="updatePasswordForm.errors.current_password"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="new-password">New password</label>
                <input v-model="updatePasswordForm.form.password" name="new-password" type="password" id="new-password"
                       class="input-base"
                       placeholder="Enter your new password">
                <FormError :errors="updatePasswordForm.errors.password"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="confirm-password">Confirm password</label>
                <input v-model="updatePasswordForm.form.password_confirmation" name="confirm-password" type="password"
                       id="confirm-password"
                       class="input-base" placeholder="Confirm your new password">
                <FormError :errors="updatePasswordForm.errors.password_confirmation"/>
            </div>

            <VButton type="submit" class="place-self-center">Update password</VButton>
        </AccountBlockForm>


        <AccountBlockForm @submit.prevent.stop="updateProfile">
            <h1 class="title">Profile</h1>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="first-name">First name</label>
                <input type="text" id="first-name" class="input-base" placeholder="Enter your first name"
                       v-model="updateProfileForm.form.first_name">
                <FormError :errors="updateProfileForm.errors.first_name"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="last-name">Last name</label>
                <input type="text" id="last-name" class="input-base" placeholder="Enter your last name"
                       v-model="updateProfileForm.form.last_name">
                <FormError :errors="updateProfileForm.errors.last_name"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="phone-number">Phone number</label>
                <input type="text" id="phone-number" class="input-base" placeholder="Enter your phone number"
                       v-model="updateProfileForm.form.telephonenumber">
                <FormError :errors="updateProfileForm.errors.telephonenumber"/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="font-medium" for="update-profile-password">Password</label>
                <input type="password" id="update-profile-password" class="input-base" placeholder="Enter your password"
                       v-model="updateProfileForm.form.password">
                <FormError :errors="updateProfileForm.errors.password"/>
            </div>
            <VButton type="submit" class="place-self-center">Update profile</VButton>
        </AccountBlockForm>

    </div>
</template>

<script setup lang="ts">
import AccountBlockForm from '@/components/AccountBlockForm.vue';
import {reactive, toRaw} from 'vue';
import VButton from '@/components/VButton.vue';
import {useAxios} from '@/plugins/axios';
import {FormWithErrors, UpdatePasswordForm, UpdateEmailForm, UpdateProfileForm} from '@/types/form-types';
import {useUserStore} from '@/stores/UserStore';
import {UserModel} from '@/types/model-types';
import pick from '@/functions/pick';
import FormError from '@/components/FormError.vue';

const axios = useAxios();
const userStore = useUserStore();
const user = userStore.user as Partial<UserModel>;

const updateEmailForm = reactive<FormWithErrors<UpdateEmailForm>>({
    form: {
        ...pick(user, ['email']),
        password: ''
    },
    errors: {
        email: [],
        password: []
    }
});

const updateEmail = async () => {
    if (confirm('Are you sure you want to update your email?')) {
        await axios.simplePut<null, UpdateEmailForm>('/account/email', toRaw(updateEmailForm.form), {
            handleFormErrors: (errors) => {
                updateEmailForm.errors = errors;
            },
            handleSuccess: () => {
                updateEmailForm.form.password = '';
                userStore.fetchUser();
            }
        });
    }
};

const updatePasswordForm = reactive<FormWithErrors<UpdatePasswordForm>>({
    form: {
        current_password: '',
        password: '',
        password_confirmation: ''
    },
    errors: {
        current_password: [],
        password: [],
        password_confirmation: []
    }
});

const updatePassword = async () => {
    if (confirm('Are you sure you want to update your password?')) {
        await axios.simplePut<null, UpdatePasswordForm>('/account/password', toRaw(updatePasswordForm.form), {
            handleFormErrors: (errors) => {
                updatePasswordForm.errors = errors;
            },
            handleSuccess: () => {
                userStore.fetchUser();
                updatePasswordForm.form.current_password = '';
                updatePasswordForm.form.password = '';
                updatePasswordForm.form.password_confirmation = '';
            }
        });
    }
};

const updateProfileForm = reactive<FormWithErrors<UpdateProfileForm>>({
    form: {
        ...pick(user, ['first_name', 'last_name', 'telephonenumber']),
        password: ''
    },
    errors: {
        first_name: [],
        last_name: [],
        telephonenumber: [],
        password: []
    }
});

const updateProfile = async () => {
    if (confirm('Are you sure you want to update your profile?')) {
        await axios.simplePut<null, UpdateProfileForm>('/account', toRaw(updateProfileForm.form), {
            handleFormErrors: (errors) => {
                updateProfileForm.errors = errors;
            },
            handleSuccess: () => {
                userStore.fetchUser();
                updateProfileForm.form.password = '';
            }
        });
    }
};

</script>
