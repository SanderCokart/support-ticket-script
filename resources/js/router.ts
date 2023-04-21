import {CreateTicket, Dashboard, IndexTickets, Login, ShowTicket, Account} from '@/pages';

const routes = [
    // Guest
    { path: '/', redirect: '/login' },
    { path: '/login', component: Login, name: 'login', meta: { requiresGuest: true } },
    { path: '/dashboard', component: Dashboard, name: 'dashboard', meta: { requiresAuth: true } },

    // Account
    { path: '/dashboard/account', component: Account, name: 'account', meta: { requiresAuth: true } }

    // { path: '/login', component: Login, name: 'login', meta: { requiresGuest: true } },

    // Dashboard
    // { path: '/dashboard', component: Dashboard, name: 'dashboard', meta: { requiresAuth: true } },
    // { path: '/dashboard/tickets', component: IndexTickets, name: 'tickets-index', meta: { requiresAuth: true } },
    // { path: '/dashboard/tickets/:id', component: ShowTicket, name: 'tickets-show', props: true, meta: { requiresAuth: true } },
    // { path: '/dashboard/tickets/create', component: CreateTicket, name: 'tickets-create', meta: { requiresAuth: true } },

    // Account
    // { path: '/dashboard/account', component: Account, name: 'account', meta: { requiresAuth: true } }
];

export default routes;
