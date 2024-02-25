import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Interceptar requests da aplicação
axios.interceptors.request.use(
    config => {
        config.headers.Accept = 'application/json'
        //console.log('Interceptando request antes do envio', config);
        return config;
    },
    error => {
        console.log('Erro na requisição: ', error);
        return Promise.reject(error);
    }
);


// Interceptar responses da aplicação
axios.interceptors.response.use(
    response => {
        //console.log('Interceptando a resposta antes da aplicação', response);
        return response;
    },
    error => {
        console.log('Erro na resposta: ', error.response);

        if(error.response.status == 401 && error.response.data.message == 'Token has expired') {
            /*axios.post('http://localhost:8000/api/refresh')
                .then(response => {
                    console.log('Refresh efetuado com sucesso: ', response);
                })
                .catch(errors => {
                    console.log(errors);
                })*/
        }

        return Promise.reject(error);
    }
);


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
