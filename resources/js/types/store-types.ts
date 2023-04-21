import type {Ref} from 'vue';
import type {UserModel} from '@/types/model-types';

export interface UserStore {
    user: Readonly<Ref<UserModel | undefined>>;
    setUser: (user: UserModel) => void;
    accessToken?: Readonly<Ref<string | undefined>>;
    setAccessToken: (accessToken: string) => void;
    isLoggedIn: Readonly<Ref<boolean>>;
}
