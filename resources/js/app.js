import { createApp } from 'vue';
import axios from 'axios';
import GarbageBinMap from './components/GarbageBinMap.vue';

// Set Axios base URL
axios.defaults.baseURL = 'http://127.0.0.1:8000/api';

const app = createApp({});

// Make Axios globally available
app.config.globalProperties.$axios = axios;

// Register components
app.component('garbage-bin-map', GarbageBinMap);

// Mount the app
app.mount('#app');
