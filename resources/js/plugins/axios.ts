import type {AxiosInstance, AxiosPromise, AxiosRequestConfig} from 'axios';
import axios from 'axios';
import {App} from 'vue';
import {AxiosKey} from '@/plugins/symbols';
import injectStrict from '@/functions/injectStrict';

const handler = async (promise: AxiosPromise, config?: CustomAxiosRequestConfig): Promise<CustomApiResponse> => {
    try {
        const { data, status } = await promise;

        config?.handleSuccess?.(data.message || data);

        return { data, status, error: null, type: 'success' };
    } catch (error: any) {
        if (error?.response) {
            // outside the 2xx range
            // if 422 form errors | validation errors | unprocessable entity
            if (error.response.status === 422) {
                config?.handleFormErrors?.(error.response.data.errors);
                return {
                    data: null,
                    status: error.response.status,
                    errors: error.response.data.errors,
                    message: error.response.data.message,
                    type: 'form'
                };
            }

            // other 4xx errors
            if (error.response.status.toString().startsWith('4')) {
                config?.handleClientError?.(error.response.data?.message || error.response.data);
                return {
                    data: null,
                    status: error.response.status,
                    error: error.response.data?.message || error.response.data,
                    type: 'client'
                };
            }

            // other 5xx errors
            if (error.response.status.toString().startsWith('5')) {
                config?.handleServerError?.(error.response.data?.message || error.response.data);
                return {
                    data: null,
                    status: error.response.status,
                    error: error.response.data?.message || error.response.data,
                    type: 'server'
                };
            }
        } else if (error.request) {
            config?.handleErrorMessage?.(error.message);
            // request was made but no response was received
            console.error('Error', error.message);
            return { data: null, status: 0, error: error.message, type: 'default' };
        }

        config?.handleErrorMessage?.(error.message);
        // The request was never made
        console.error('Error', error.message);
        return { data: null, status: 0, error: error.message, type: 'default' };
    }
};

export const customAxios = (config?: CustomAxiosRequestConfig) => {

    const axiosInstance = axios.create({
        ...config,
        withCredentials: true,
        baseURL: config?.baseURL || import.meta.env.VITE_API_URL,
        headers: {
            'Accept': 'application/json',
            ...config?.headers
        }
    });

    axiosInstance.interceptors.request.use((config) => {
        config.headers.Authorization = `Bearer ${localStorage.getItem('access_token')}`;
        return config;
    });

    return ({
        ...axiosInstance,
        simpleGet: (url: string, config?: CustomAxiosRequestConfig): Promise<CustomApiResponse> => {
            return handler(axiosInstance.get(url, config), config);
        },
        simpleDelete: (url: string, config?: CustomAxiosRequestConfig): Promise<CustomApiResponse> => {
            return handler(axiosInstance.delete(url, config), config);
        },
        simplePost: (url: string, data?: any, config?: CustomAxiosRequestConfig): Promise<CustomApiResponse> => {
            return handler(axiosInstance.post(url, data, config), config);
        },
        simplePut: (url: string, data?: any, config?: CustomAxiosRequestConfig): Promise<CustomApiResponse> => {
            return handler(axiosInstance.put(url, data, config), config);
        },
        simplePatch: (url: string, data?: any, config?: CustomAxiosRequestConfig): Promise<CustomApiResponse> => {
            return handler(axiosInstance.patch(url, data, config), config);
        }
    }) as CustomAxiosInstance;
};

interface CustomAxiosRequestConfig<Data = any, Submitted extends {} = {}> extends AxiosRequestConfig {
    handleSuccess?: (data: Data) => void;
    handleFormErrors?: (errors: FormError<Submitted>) => void;
    handleClientError?: (error: string) => void;
    handleServerError?: (error: string) => void;
    handleErrorMessage?: (error: string) => void;
}

export interface CustomAxiosInstance extends AxiosInstance {
    simpleGet<Data = any>(url: string, config?: CustomAxiosRequestConfig<Data>): Promise<CustomApiResponse<Data>>;

    simpleDelete<Data = any>(url: string, config?: CustomAxiosRequestConfig<Data>): Promise<CustomApiResponse<Data>>;

    simplePost<Data = any, Submitted extends {} = {}>(url: string, data?: any, config?: CustomAxiosRequestConfig<Data, Submitted>): Promise<CustomApiResponse<Data, Submitted>>;

    simplePut<Data = any, Submitted extends {} = {}>(url: string, data?: any, config?: CustomAxiosRequestConfig<Data, Submitted>): Promise<CustomApiResponse<Data, Submitted>>;

    simplePatch<Data = any, Submitted extends {} = {}>(url: string, data?: any, config?: CustomAxiosRequestConfig<Data, Submitted>): Promise<CustomApiResponse<Data, Submitted>>;
}

export type CustomApiResponse<Data = any, Submitted extends {} = {}> =
    SuccessResponse<Data>
    | FormErrorResponse<Submitted>
    | ServerErrorResponse
    | ClientErrorResponse
    | DefaultErrorResponse;

export interface SuccessResponse<Data = any> {
    data: Data;
    error: null;
    status: number;
    type: 'success';
}

export type FormError<Data> = {
    [key in keyof Data]: string[];
};

export interface FormErrorResponse<Submitted> {
    data: null;
    message: string;
    errors: FormError<Submitted>;
    status: number;
    type: 'form';
}

export interface ServerErrorResponse {
    data: null;
    error: string;
    status: number;
    type: 'server';
}

export interface ClientErrorResponse {
    data: null;
    error: string;
    status: number;
    type: 'client';
}

export interface DefaultErrorResponse {
    data: null;
    error: string;
    status: number;
    type: 'default';
}

export const AxiosPlugin = {
    install: (app: App, config: CustomAxiosRequestConfig) => {
        app.provide(AxiosKey, customAxios(config));
    }
};

export const useAxios = () => {
    return injectStrict(AxiosKey);
};

export default customAxios;
