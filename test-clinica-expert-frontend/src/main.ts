import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import { createPinia } from "pinia";
import router from "./router"

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome"
import { library } from '@fortawesome/fontawesome-svg-core'
import {
    faEllipsisV,
    faChartSimple,
    faClone,
    faPenToSquare,
    faTrashCan,
    faLink,
    faHouse,
    faRightLeft,
    faSliders,
    faMagnifyingGlass,
    faPlus,
    faEye,
    faHandPointer
} from '@fortawesome/free-solid-svg-icons'


// import './assets/main.css'

library.add(
    faEllipsisV,
    faChartSimple,
    faClone,
    faPenToSquare,
    faTrashCan,
    faLink,
    faHouse,
    faRightLeft,
    faSliders,
    faMagnifyingGlass,
    faPlus,
    faEye,
    faHandPointer
)

createApp(App)
    .use(router)
    .use(createPinia())
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount('#app')
