
import auth_routes from "../components/auth/routes";
import AuthLayout from "../components/auth/AuthLayout";

import AppLayout from "../components/app/AppLayout";
import app_routes from "../components/app/routes";

const routes = [
    {path:'',redirect:'app'},
    {path: '/app', component: AppLayout,children:app_routes, meta: { requiresAuth: true}},
    {path: '/auth', component: AuthLayout,children:auth_routes , meta: { requiresGuest: true }},
    { path: '*', component: () => import('../components/static/Error404.vue')}
];
export default routes

