import {UserModel} from '@/types/model-types';

export interface LoginForm {
    email: string;
    password: string;
}

export interface TicketForm {
    title: string;
    content: string;
    category_id: number;
}

export interface UpdatePasswordForm {
    current_password: string;
    password: string;
    password_confirmation: string;
}

export interface UpdateEmailForm {
    email: string;
    password: string;
}

export type UpdateProfileForm = Pick<UserModel, 'first_name' | 'last_name' | 'telephonenumber'> & {
    password: string;
}

export type FormWithErrors<Form> = {
    form: Form;
    errors: {
        [key in keyof Form]: string[];
    }
};
