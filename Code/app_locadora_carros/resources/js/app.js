import './bootstrap';
import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state: {
        item: {},
        transacao: {status: '', mensagem: ''}
    }
})

const app = createApp({});
app.use(store)

import LoginComponent from './components/LoginComponent.vue';
import Home from './components/Home.vue';
import Marcas from './components/Marcas.vue';
import Card from './components/Card.vue';
import InputContainer from './components/InputContainer.vue';
import Table from './components/Table.vue';
import Modal from './components/Modal.vue';
import Alert from './components/Alert.vue';
import Paginate from './components/Paginate.vue';

app.component('login-component', LoginComponent);
app.component('home-component', Home);
app.component('marcas-component', Marcas);
app.component('card-component', Card);
app.component('input-container-component', InputContainer);
app.component('table-component', Table);
app.component('modal-component', Modal);
app.component('alert-component', Alert);
app.component('paginate-component', Paginate);

app.mount('#app');
