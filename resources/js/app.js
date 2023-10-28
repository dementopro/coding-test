import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia'

import Alpine from 'alpinejs';
import TaskCard from './components/TaskCard.vue';
import TaskColumn from './components/TaskColumn.vue';
import KanbanBoard from './components/KanbanBoard.vue';
import Statistic from './components/Statistic.vue';
import GenericModal from './components/modals/GenericModal.vue';
import { VueSpinnersPlugin } from 'vue3-spinners';
import { LoadingPlugin } from 'vue-loading-overlay';
import VueTippy from 'vue-tippy';
import 'tippy.js/dist/tippy.css';
import 'vue-loading-overlay/dist/css/index.css';
import 'vue3-toastify/dist/index.css';

const pinia = createPinia()
const app = createApp({});
app.use(pinia);
app.use(VueSpinnersPlugin);
app.use(LoadingPlugin);
app.use(
    VueTippy,
    {
        directive: 'tippy',
        commponent: 'tippy'
    }
);

app.component('TaskCard', TaskCard)
    .component('TaskColumn', TaskColumn)
    .component('KanbanBoard', KanbanBoard)
    .component('Statistic', Statistic)
    .component('GenericModal', GenericModal)

app.mount("#app");


window.Alpine = Alpine;

Alpine.start();
