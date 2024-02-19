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

                        <table-component
                            :dados="marcas.data"
                            :visualizar = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalMarcaVisualizar' }"
                            :atualizar = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalMarcaAtualizar' }"
                            :remover = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalMarcaRemover' }"
                            :titulos=" {
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'}
                            }"
                        ></table-component>

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


                <!-- Modal adicionar marca -->
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

                <!-- Modal visualizar marca -->
                <modal-component id="modalMarcaVisualizar" titulo="Visualizar marca">

                    <template v-slot:alertas>

                    </template>

                    <template v-slot:conteudo>

                        <input-container-component titulo="ID">
                            <input type="number" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>

                        <input-container-component titulo="Nome">
                            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                        </input-container-component>

                        <input-container-component titulo="Imagem">
                            <div>
                                <img :src="'/storage/' + $store.state.item.imagem" v-if="$store.state.item.imagem">
                            </div>
                        </input-container-component>

                        <input-container-component titulo="Data de criação">
                            <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                        </input-container-component>

                    </template>

                    <template v-slot:rodape>
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>-->
                    </template>

                </modal-component>


                <!-- Modal atualização marca -->
                <modal-component id="modalMarcaAtualizar" titulo="Atualizar marca">

                <template v-slot:alertas>
                    <alert-component v-if="$store.state.transacao.status == 'sucesso'" tipo="success" titulo="Marca atualizada com sucesso." :detalhes="{mensagem: ''}"></alert-component>
                    <alert-component v-if="$store.state.transacao.status == 'erro'" tipo="danger" titulo="Erro ao atualizar marca." :detalhes="{mensagem: ''}"></alert-component>
                </template>

                <template v-slot:conteudo>

                    <div class="form-group">
                        <input-container-component titulo="Nome da marca" id="atualizarNome" id-help="atualizarNomeHelp" texto-help="Informe o nome da marca">
                            <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome da marca" v-model="$store.state.item.nome">
                        </input-container-component>

                        <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-help="Selecione uma imagem no formato PNG">
                            <input type="file" class="form-control" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                            <!-- Onchange pois não é possível utilizar v-on em inputs type file -->
                        </input-container-component>
                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>

                </modal-component>


                <!-- Modal remoção de marca -->
                <modal-component id="modalMarcaRemover" titulo="Remover marca">

                    <template v-slot:alertas>
                        <alert-component v-if="$store.state.transacao.status == 'sucesso'" tipo="success" titulo="Marca removida com sucesso." :detalhes="{mensagem: ''}"></alert-component>
                        <alert-component v-if="$store.state.transacao.status == 'erro'" tipo="danger" titulo="Erro ao remover marca." :detalhes="{mensagem: ''}"></alert-component>
                    </template>

                    <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">

                        <input-container-component titulo="ID">
                            <input type="number" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>

                        <input-container-component titulo="Nome">
                            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                        </input-container-component>

                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button v-if="$store.state.transacao.status != 'sucesso'" type="button" class="btn btn-danger" @click="remover()">Remover</button>
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
            },

            atualizar() {

                let url = this.urlBase + '/' + this.$store.state.item.id;
                let formData = new FormData();
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                };

                formData.append('_method', 'PATCH');
                formData.append('nome', this.$store.state.item.nome);

                if(this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0]);
                }

                axios.post(url, formData, config)
                    .then(response => {
                        console.log('Marca atualizada com sucesso:', response);
                        atualizarImagem.value = '';
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = 'Registro de marca atualizado com sucesso!';
                        this.carregarLista();
                    })
                    .catch(errors => {
                        if (errors.response) {
                            console.log('Erro ao tentar atualizar marca. Status:', errors.response.status);
                            console.log('Detalhes do erro:', error.response.data);
                            this.$store.state.transacao.status = errors.response.data.message;
                            this.$store.state.transacao.mensagem = errors.response.data.errors;
                        }
                    });

            },

            remover() {

                let confirmacao = confirm('Tem certeza que deseja remover esse registro?');

                if(!confirmacao) {
                    return false
                }

                let url = this.urlBase + '/' + this.$store.state.item.id;
                let formData = new FormData();

                formData.append('_method', 'delete');

                axios.post(url, formData)
                    .then(response => {
                        console.log("Registro removido com sucesso!", response);
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = response.data.msg;
                        this.carregarLista();
                    })
                    .catch(errors => {
                        console.log("Houve um erro ao tentar remover o registro", errors);
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = 'Erro ao remover registro';
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
