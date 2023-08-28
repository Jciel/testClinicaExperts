import {createRouter, createWebHistory, Router, RouteRecordRaw} from "vue-router";
import ListShortLinks from "../views/ListShortLinks.vue";


const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'Home',
        redirect: 'list-links'
    },
    {
        path: '/list-links',
        name: 'ListLinks',
        component: ListShortLinks
    }
]

const index: Router = createRouter({
    history: createWebHistory(),
    routes
})

export default index
