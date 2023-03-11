import './bootstrap';
//import 'vfonts/Lato.css';

import {createApp} from 'vue';
import router from './router'
import { createPinia } from 'pinia'

import App from './App.vue';
//import { create } from 'lodash';

import naive from 'naive-ui';
import './axios/index'

const pinia = createPinia()
const app = createApp(App);

app.use(pinia)
app.use(naive);
app.use(router);
app.mount("#app");