import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import LoginComponent from './components/LoginComponent.vue';
import Home from './components/Home.vue';

app.component('login-component', LoginComponent);
app.component('home-component', Home);

app.mount('#app');
