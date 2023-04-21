import type {InjectionKey} from 'vue';
import {CustomAxiosInstance} from '@/plugins/axios';

export const AxiosKey: InjectionKey<CustomAxiosInstance> = Symbol('axios');
