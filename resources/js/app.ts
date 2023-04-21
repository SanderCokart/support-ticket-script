import './bootstrap';
import '../sass/app.scss';

import Root from '@/components/Root.vue';
import {createApp} from 'vue';
import {AxiosPlugin} from '@/plugins/axios';
import routes from '@/router';
import {createWebHistory, createRouter} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes
});

createApp(Root)
    .use(AxiosPlugin, { baseURL: import.meta.env.VITE_API_URL })
    .mount('#app');
