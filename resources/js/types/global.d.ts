import {CustomAxiosInstance} from '@/functions/axios';

declare global {
    interface Window {
        axios: CustomAxiosInstance;
    }
}
