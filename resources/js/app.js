/**import './bootstrap';*/

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


/**Mount Vue */
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';

const app = createApp(App);
app.use(router);
app.mount('#app');

