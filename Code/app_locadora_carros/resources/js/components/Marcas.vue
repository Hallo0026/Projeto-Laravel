<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Buscar marcas"> <!-- Card de busca -->

                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col-4 mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-help="Opcional. Informe o ID da marca">
                                    <input v-model="busca.id" type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col-8 mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-help="Opcional. Informe o nome da marca">
                                    <input v-model="busca.nome" type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome">
                                </input-container-component>
                            </div>
                        </div> <!-- row -->

                    </template>

                    <template v-slot:rodape>
                        <button @click="pesquisar()" class="btn btn-primary btn-sm">Pesquisar</button>
                    </template>

                </card-component> <!-- Fim card de busca -->


                <card-component titulo="Relação de marcas"> <!-- Card relações de marcas -->

                    <template v-slot:conteudo>
                        <!--<table-component :dados="marcas" :titulos="['id', 'nome', 'imagem']"></table-component>-->

                        <table-component
                            :dados="marcas.data"
                            :titulos=" {
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'}
                            }"
                        ></table-component>

                        <!-- Os títulos passados devem ser iguais às chaves da propriedade dados -->
                    </template>

                    <template v-slot:rodape>

                        <div class="row">

                            <div class="col-8">
                                <!--<paginate-component
                                :dados="marcas"
                                @paginar="carregarLista"
                                ></paginate-component>-->
                                <paginate-component>
                                    <li v-for="l, key in marcas.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col-4">
                                <button type="button" class="btn btn-primary btn-adicionar btn-sm" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                            </div>

                        </div>

                    </template>

                </card-component> <!-- Fim card relação de marcas -->


                <!-- Modal -->
                <modal-component id="modalMarca" titulo="Adicionar marca">

                    <template v-slot:alertas>
                        <alert-component titulo="Cadastro realizado com sucesso!" tipo="success" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'adicionado'"></alert-component>
                        <alert-component titulo="Erro ao tentar cadastrar a marca" tipo="danger" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'erro'"></alert-component>
                    </template>

                    <template v-slot:conteudo>

                        <div class="form-group">
                            <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-help="Informe o nome da marca">
                                <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca" v-model="nomeMarca">
                            </input-container-component>

                            <input-container-component titulo="Imagem" id="novaImagem" id-help="novaImagemHelp" texto-help="Selecione uma imagem no formato PNG">
                                <input type="file" class="form-control" id="novaImagem" aria-describedby="novaImagem" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                                <!-- Onchange pois não é possível utilizar v-on em inputs type file -->
                            </input-container-component>
                        </div>

                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                    </template>

                </modal-component>

            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';

    export default {

        mounted() {
            this.carregarLista();
        },

        data() {
            return {
                marcas: { data: [] },
                urlFiltro: '',
                urlPaginacao: '',
                urlBase: 'http://localhost:8000/api/v1/marca',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                busca : { id: '', nome: ''}
            }
        },

        methods: {

            paginacao(l) {
                if(l.url) {
                    this.urlPaginacao = l.url.split('?')[1];
                    this.carregarLista();
                }
            },

            pesquisar() {

                let filtro = '';

                for(let chave in this.busca) {

                    if(this.busca[chave]) {

                        if(filtro != '') {
                            filtro += ';';
                        }

                        filtro += chave + ':like:' + this.busca[chave];
                        console.log(filtro);
                    }
                }

                if(filtro != '') {
                    this.urlFiltro = '&filtro=' + filtro;
                } else {
                    this.urlFiltro = '';
                }

                this.carregarLista();

            },

            carregarLista() {

                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro;

                console.log(url);

                axios.get(url)
                    .then(response => {
                        this.marcas = response.data;
                        //console.log(this.marcas);
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            },

            carregarImagem(event) {
                this.arquivoImagem = event.target.files
            },


            salvar() {

                let formData = new FormData();

                formData.append('nome', this.nomeMarca);
                formData.append('imagem', this.arquivoImagem[0]); // índice 0 pois é esperado trabalhar com um único arquivo

                let config = {
                    headers: {
                        'Content-type': 'multipart/form-data',
                        'Accept': 'application/json'
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado';
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id
                        };
                        //console.log(response);
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro';
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                        //console.log(errors.response.data.message);
                    });
            }
        },

    }

</script>

<style>
    .card-header {
        font-size: 1.2rem;
        font-weight: 700;
    }

    ul.pagination {
        margin-bottom: 0;
    }

    .btn-adicionar {
        margin-top: 4px;
    }


</style>
