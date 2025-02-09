import { createRouter, createWebHistory } from 'vue-router';

// Import views
import Dashboard from './views/Dashboard.vue';
import UMServer from './views/UMServer.vue';

const routes = [
    { path: '/', component: Dashboard },
    { path: '/um-server', component: UMServer },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
