import '../sass/app.scss';

import Root from '@/components/Root.vue';
import {createApp} from 'vue';
import {createRouter, createWebHistory} from 'vue-router';
import {AxiosPlugin} from '@/plugins/axios';
import {createPinia} from 'pinia';
import {useUserStore} from '@/stores/UserStore';
import routes from '@/router';

const initApp = () => {
    return createApp(Root)
        .directive('focus',{
            mounted(el) {
                el.focus();
            }
        })
        .use(AxiosPlugin, { baseURL: import.meta.env.VITE_API_URL })
        .use(createPinia());
};

const app = initApp();

//<editor-fold desc="configure router">
const userStore = useUserStore();
const initRouter = () => {
    const router = createRouter({
        history: createWebHistory(),
        routes
    });
    router.beforeEach((to, from, next) => {
        //if any matched route requires auth
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
        const requiresGuest = to.matched.some(record => record.meta.requiresGuest);

        if (requiresGuest && userStore.isLoggedIn) {
            next({ name: 'dashboard' });
        } else if (requiresAuth && !userStore.isLoggedIn) {
            next({ name: 'login' });
        } else {
            next(); // does not require auth
        }
    });

    return router;
};
//</editor-fold>




// must fetch user before initiating the router due to router.beforeEach
const mountApp = async () => {
    await userStore.fetchUser();
    app.use(initRouter());
    app.mount('#app');
};

mountApp();
