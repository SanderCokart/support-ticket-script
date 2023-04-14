import './bootstrap';
import '../sass/app.scss';

import App from '@/components/App.vue';
import {createApp} from 'vue';
import {createRouter, createWebHistory} from 'vue-router';
import routes from '@/routes/routes';

const router = createRouter({
    history: createWebHistory(),
    routes
});

createApp(App)
    .use(router)
    .mount('#app');
