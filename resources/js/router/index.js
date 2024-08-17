import { createRouter, createWebHistory } from "vue-router"; 
import '@mdi/font/css/materialdesignicons.css';
import home from "../components/HomeRoute.vue";
import about from "../components/About.vue";
import notfound from "../components/Notfound.vue";
import service from '../components/service.vue';
import location from '../components/location.vue';
import contact from '../components/contact.vue';
import emis from "../components/emis.vue";


const routes = [
    {
        path:'/',
        component: home
    },
    {
        path:'/about',
        component: about
    },

    {
        path:'/service',
        component:service
    },
    {
        path:'/location',
        component:location
    },
    {
        path:'/contact',
        component: contact
    },
    {
        path:'/emis',
        component:emis
    },
    {
        path:'/:pathMatch(.*)*',
        component: notfound
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router