<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Buscar veículos"> <!-- Card de busca -->

                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col-4">
                                <input-container-component titulo="Placa" id="inputPlaca" id-help="inputPlacaHelp" texto-help="">
                                    <input v-model="busca.placa" type="text" class="form-control" id="inputPlaca" aria-describedby="inputTelefoneHelp" placeholder="Placa">
                                </input-container-component>
                            </div>
                        </div> <!-- row -->

                    </template>

                    <template v-slot:rodape>
                        <button @click="pesquisar()" class="btn btn-primary btn-sm">Pesquisar</button>
                    </template>

                </card-component> <!-- Fim card de busca -->


                <card-component titulo="Relação de veículos"> <!-- Card relações de carros -->

                    <template v-slot:conteudo>

                        <table-component
                            :dados="carros.data"
                            :visualizar = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalcarroVisualizar' }"
                            :atualizar = "{ visivel: false, dataBsToggle: 'modal', dataBsTarget: '#modalcarroAtualizar' }"
                            :remover = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalcarroRemover' }"
                            :titulos=" {
                                id: {titulo: 'ID', tipo: 'texto'},
                                modelo: {titulo: 'Modelo', tipo: 'texto'},
                                placa: {titulo: 'Placa', tipo: 'texto'},
                                km: {titulo: 'Kilometragem', tipo: 'texto'},
                                disponivel: {titulo: 'Disponível', tipo: 'boolean'},
                            }"
                        ></table-component>

                    </template>

                    <template v-slot:rodape>

                        <div class="row">

                            <div class="col-8">
                                <paginate-component>
                                    <li v-for="l, key in carros.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col-4">
                                <button type="button" class="btn btn-primary btn-adicionar btn-sm" data-bs-toggle="modal" data-bs-target="#modalcarro">Adicionar</button>
                            </div>

                        </div>

                    </template>

                </card-component> <!-- Fim card relação de carros -->


                <!-- Modal adicionar carro -->
                <modal-component id="modalcarro" titulo="Adicionar carro">

                    <template v-slot:alertas>
                        <alert-component titulo="Cadastro realizado com sucesso!" tipo="success" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'adicionado'"></alert-component>
                        <alert-component titulo="Erro ao tentar cadastrar a carro" tipo="danger" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'erro'"></alert-component>
                    </template>

                    <template v-slot:conteudo>

                        <div class="form-group">

                            <div class="row">

                                <!--<div class="col-12">
                                    <input-container-component titulo="Modelo" id="novoModelo" id-help="novoModeloHelp" texto-help="">
                                        <input type="text" class="form-control" id="novoModelo" aria-describedby="novoModeloHelp" placeholder="Modelo do veículo" v-model="modelo">
                                    </input-container-component>
                                </div>-->

                                <div class="col-12">
                                    <input-container-component titulo="Modelo: " id="novoModelo" id-help="novoModeloHelp" texto-help="">
                                        <input style="margin-left: 4px;" type="text" v-model="searchQuery" placeholder="Pesquisar...">
                                        <select class="form-select" id="novoModelo" aria-describedby="novoModeloHelp" v-model="selectedModelo">
                                            <option v-for="m in modelosFiltrados" :value="m.id">{{ m.nome }}</option>
                                        </select>
                                    </input-container-component>
                                </div>

                                <div class="col-12">
                                    <input-container-component titulo="Placa" id="novoPlaca" id-help="novoPlacaHelp" texto-help="">
                                        <input type="text" class="form-control" id="novoPlaca" aria-describedby="novoPlacaHelp" placeholder="Placa" v-model="placa">
                                    </input-container-component>
                                </div>

                                <div class="col-12">
                                    <input-container-component titulo="Kilometragem" id="novoKilometragem" id-help="novoKilometragemHelp" texto-help="">
                                        <input type="number" class="form-control" id="novoKilometragem" aria-describedby="novoKilometragemHelp" placeholder="Kilometragem" v-model="kilometragem">
                                    </input-container-component>
                                </div>

                            </div> <!-- row -->

                        </div>

                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                    </template>

                </modal-component>

                <!-- Modal visualizar carro -->
                <modal-component id="modalcarroVisualizar" titulo="Visualizar carro">

                    <template v-slot:alertas>

                    </template>

                    <template v-slot:conteudo>

                        <div class="row">

                            <div class="col-12 mb-3">
                                <input-container-component titulo="Modelo">
                                    <input type="text" class="form-control" :value="$store.state.item.modelo ? $store.state.item.modelo.nome : ''" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-12 mb-3">
                                <input-container-component titulo="Placa">
                                    <input type="text" class="form-control" :value="$store.state.item.placa" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-6 mb-3">
                                <input-container-component titulo="Kilometragem">
                                    <input type="text" class="form-control" :value="$store.state.item.km" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-6 mb-3">
                                <input-container-component titulo="Disponível">
                                    <input type="text" class="form-control" :value="$store.state.item.disponivel == 1 ? 'Sim' : 'Não'" disabled>
                                </input-container-component>
                            </div>

                        </div>

                    </template>

                    <template v-slot:rodape>
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>-->
                    </template>

                </modal-component>


                <!-- Modal atualização carro -->
                <modal-component id="modalcarroAtualizar" titulo="Atualizar carro">

                <template v-slot:alertas>
                    <alert-component v-if="$store.state.transacao.status == 'sucesso'" tipo="success" titulo="carro atualizado com sucesso." :detalhes="{mensagem: ''}"></alert-component>
                    <alert-component v-if="$store.state.transacao.status == 'erro'" tipo="danger" titulo="Erro ao atualizar carro." :detalhes="{mensagem: ''}"></alert-component>
                </template>

                <template v-slot:conteudo>

                    <div class="form-group">

                        <div class="row">

                            <input-container-component titulo="Placa" id="atualizarPlaca" id-help="atualizarPlacaHelp" texto-help="Informe a placa do carro">
                                <input type="text" class="form-control" id="atualizarPlaca" aria-describedby="atualizarPlacaHelp" placeholder="Placa" v-model="$store.state.item.placa">
                            </input-container-component>

                        </div>

                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>

                </modal-component>


                <!-- Modal remoção de carro -->
                <modal-component id="modalcarroRemover" titulo="Remover carro">

                    <template v-slot:alertas>
                        <alert-component v-if="$store.state.transacao.status == 'sucesso'" tipo="success" titulo="carro removido com sucesso." :detalhes="{mensagem: ''}"></alert-component>
                        <alert-component v-if="$store.state.transacao.status == 'erro'" tipo="danger" titulo="Erro ao remover carro." :detalhes="{mensagem: ''}"></alert-component>
                    </template>

                    <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">

                        <input-container-component titulo="ID">
                            <input type="number" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container-component>

                        <input-container-component titulo="Nome">
                            <input type="text" class="form-control" :value="$store.state.item.modelo ? $store.state.item.modelo.nome : ''" disabled>
                        </input-container-component>

                        <input-container-component titulo="Placa">
                            <input type="text" class="form-control" :value="$store.state.item.placa" disabled>
                        </input-container-component>

                        <input-container-component titulo="Kilometragem">
                            <input type="text" class="form-control" :value="$store.state.item.km" disabled>
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
    import Swal from 'sweetalert2';

    export default {

        mounted() {
            this.carregarLista();
            this.getModelos();
        },

        data() {
            return {
                carros: { data: [] },
                urlFiltro: '',
                urlPaginacao: '',
                modelos: [],
                searchQuery: '',
                selectedModelo: '',
                modelo: '',
                placa: '',
                marca: '',
                kilometragem: '',
                disponivel: '',
                urlBase: 'http://localhost:8000/api/v1/carro',
                transacaoStatus: '',
                transacaoDetalhes: {},
                busca : { modelo: '', placa: ''}
            }
        },

        computed: {
            modelosFiltrados() {
                return this.modelos.filter(modelo =>
                    modelo.nome.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
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
                        this.carros = response.data;
                        //console.log(this.carros);
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            },

            salvar() {

                let formData = new FormData();

                formData.append('modelo_id', this.selectedModelo);
                formData.append('placa', this.placa);
                formData.append('disponivel', 1);
                formData.append('km', this.kilometragem);

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
                        this.carregarLista();
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
                formData.append('id', this.$store.state.item.id);
                formData.append('nome', this.$store.state.item.nome);
                formData.append('telefone', this.$store.state.item.telefone);
                formData.append('cpf', this.$store.state.item.cpf);

                axios.post(url, formData, config)
                    .then(response => {
                        console.log('carro atualizado com sucesso:', response);
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = 'Registro do carro atualizado com sucesso!';
                        this.carregarLista()
                    })
                    .catch(errors => {
                        if (errors.response) {
                            console.log('Erro ao tentar atualizar carro. Status:', errors.response.status);
                            console.log('Detalhes do erro:', error.response.data);
                            this.$store.state.transacao.status = errors.response.data.message;
                            this.$store.state.transacao.mensagem = errors.response.data.errors;
                        }
                    });

            },

            remover() {

                Swal.fire({
                    title: "Tem certeza que deseja remover esse registro?",
                    text: "Esta ação não pode ser revertida",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirmar"
                    }).then((result) => {
                    if (result.isConfirmed) {

                        let url = this.urlBase + '/' + this.$store.state.item.id;
                        let formData = new FormData();

                        formData.append('_method', 'delete');

                        axios.post(url, formData)
                            .then(response => {
                                console.log("Registro removido com sucesso!", response);
                                this.$store.state.transacao.status = 'sucesso';
                                this.$store.state.transacao.mensagem = response.data.msg;
                                this.carregarLista();
                                /*Swal.fire({
                                    title: "Registro removido com sucesso",
                                    //text: "Your file has been deleted.",
                                    icon: "success"
                                });*/
                            })
                            .catch(errors => {
                                console.log("Houve um erro ao tentar remover o registro", errors);
                                this.$store.state.transacao.status = 'erro';
                                this.$store.state.transacao.mensagem = 'Erro ao remover registro';
                                /*Swal.fire({
                                    title: "Erro ao remover registro",
                                    //text: "Your file has been deleted.",
                                    icon: "error"
                                });*/
                            });
                    }
                });

            },

            getModelos() {
                axios.get('http://localhost:8000/api/v1/modelo/false')
                    .then(response => {
                        this.modelos = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    });

            }

        }

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
