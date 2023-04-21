import type {InjectionKey} from 'vue';
import {CustomAxiosInstance} from '@/plugins/axios';
import {UserStore} from '@/types/store-types';

export const AxiosKey: InjectionKey<CustomAxiosInstance> = Symbol('axios');
export const UserStoreKey: InjectionKey<UserStore> = Symbol('userStore');
