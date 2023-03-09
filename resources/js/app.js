import './bootstrap';
//import 'vfonts/Lato.css';

import {createApp} from 'vue';
import router from './router'

import App from './App.vue';
//import { create } from 'lodash';

import naive from 'naive-ui';
import './axios'


const app = createApp(App);

app.use(naive);
app.use(router);
app.mount("#app");