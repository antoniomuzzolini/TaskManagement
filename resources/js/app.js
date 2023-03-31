import './bootstrap';

import {createApp} from 'vue'

import router from './route.js';

import App from './App.vue';

import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'

const app = createApp(App)

app.use(router).use(Toast).use(LaravelPermissionToVueJS).mount("#app")