<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form method="POST" action="" @submit.prevent="login($event)">

                            <input type="hidden" name="_token" :value="csrf_token">

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus v-model="email">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" v-model="password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            Manter-me conectado
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="">
                                        Esqueceu sua senha?
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['csrf_token'],
        data() {
            return {
                email: '',
                password: ''
            }
        },
        methods: {
            login(event) {

                const url = 'http://localhost:8000/api/login';

                let config = {
                    method: 'post',
                    body: new URLSearchParams({
                        'email': this.email,
                        'password': this.password
                    })
                };

                fetch(url, config)
                    .then(response => response.json()) // Convertendo a resposta para um json
                    .then(data => { // Capturando o json na variável data
                        if(data.token) {
                            document.cookie = 'token=' + data.token + '; SameSite=Lax'; // Utilizar essa sintaxe para que os cookies sejam enviados por padrão nas requisições HTTP prevenindo ataques CSRF.
                        }

                        // Dar sequência no envio do form de autenticação
                        event.target.submit(); // Utilizado dentro do then por questão de compatibilidade com navegadores.

                    })
            }
        }
    }

</script>
