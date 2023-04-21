import {defineStore} from 'pinia';
import type {UserModel} from '@/types/model-types';
import axios from '@/plugins/axios';

interface State {
    user: UserModel | null;
}

export const useUserStore = defineStore('user', {
    state: (): State => ({
        user: null
    }),
    actions: {
        setUser(user: UserModel | null) {
            this.user = user;
        },
        setAccessToken(token: string) {
            localStorage.setItem('access_token', token);
        },
        async logout() {
            await axios().simplePost('/account/logout', null, {
                handleSuccess: () => {
                    this.$reset();
                }
            });
        },
        async fetchUser() {
            await axios().simpleGet<UserModel>(import.meta.env.VITE_API_URL + '/account/user', {
                handleSuccess: data => {
                    this.setUser(data);
                }
            });
        }
    },
    getters: {
        isLoggedIn(): boolean {
            return !!this.user?.id;
        }
    }
});
