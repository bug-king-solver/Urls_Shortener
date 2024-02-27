import './assets/main.css'
import Vue3Toastify, { type ToastContainerOptions } from 'vue3-toastify';

import { createApp } from 'vue'
import App from './App.vue'

const app = createApp(App);

app.use(Vue3Toastify, {
  autoClose: 3000,
} as ToastContainerOptions);

app.mount('#app')