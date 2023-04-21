import type {UserModel} from '@/types/model-types';

export interface LoginReturn {
    access_token: string;
    user: UserModel;
}
