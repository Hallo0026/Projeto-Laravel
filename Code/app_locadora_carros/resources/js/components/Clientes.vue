<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Buscar clientes"> <!-- Card de busca -->

                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col-4">
                                <input-container-component titulo="Nome" id="inputNome" id-help="inputNomeHelp" texto-help="">
                                    <input v-model="busca.nome" type="text" class="form-control" id="inputNome" aria-describedby="inputNomeHelp" placeholder="Nome">
                                </input-container-component>
                            </div>
                            <div class="col-4">
                                <input-container-component titulo="Telefone" id="inputTelefone" id-help="inputTelefoneHelp" texto-help="">
                                    <input v-model="busca.telefone" type="text" class="form-control" id="inputTelefone" aria-describedby="inputTelefoneHelp" placeholder="Telefone" v-mask="'(##)#####-####'">
                                </input-container-component>
                            </div>
                            <div class="col-4">
                                <input-container-component titulo="CPF" id="inputCpf" id-help="inputCpfHelp" texto-help="">
                                    <input v-model="busca.cpf" type="text" class="form-control" id="inputCpf" aria-describedby="inputCpfHelp" placeholder="CPF" v-mask="'###.###.###-##'">
                                </input-container-component>
                            </div>
                        </div> <!-- row -->

                    </template>

                    <template v-slot:rodape>
                        <button @click="pesquisar()" class="btn btn-primary btn-sm">Pesquisar</button>
                    </template>

                </card-component> <!-- Fim card de busca -->


                <card-component titulo="Relação de clientes"> <!-- Card relações de clientes -->

                    <template v-slot:conteudo>

                        <table-component
                            :dados="clientes.data"
                            :visualizar = "{ visivel: false, dataBsToggle: 'modal', dataBsTarget: '#modalclienteVisualizar' }"
                            :atualizar = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalclienteAtualizar' }"
                            :remover = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalclienteRemover' }"
                            :titulos=" {
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                telefone: {titulo: 'Telefone', tipo: 'texto'},
                                cpf: {titulo: 'CPF', tipo: 'texto'},
                            }"
                        ></table-component>

                    </template>

                    <template v-slot:rodape>

                        <div class="row">

                            <div class="col-8">
                                <!--<paginate-component
                                :dados="clientes"
                                @paginar="carregarLista"
                                ></paginate-component>-->
                                <paginate-component>
                                    <li v-for="l, key in clientes.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col-4">
                                <button type="button" class="btn btn-primary btn-adicionar btn-sm" data-bs-toggle="modal" data-bs-target="#modalcliente">Adicionar</button>
                            </div>

                        </div>

                    </template>

                </card-component> <!-- Fim card relação de clientes -->


                <!-- Modal adicionar cliente -->
                <modal-component id="modalcliente" titulo="Adicionar cliente">

                    <template v-slot:alertas>
                        <alert-component titulo="Cadastro realizado com sucesso!" tipo="success" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'adicionado'"></alert-component>
                        <alert-component titulo="Erro ao tentar cadastrar a cliente" tipo="danger" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'erro'"></alert-component>
                    </template>

                    <template v-slot:conteudo>

                        <div class="form-group">

                            <div class="row">

                                <div class="col-12">
                                    <input-container-component titulo="Nome" id="novoNome" id-help="novoNomeHelp" texto-help="">
                                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome do cliente" v-model="nomeCliente">
                                    </input-container-component>
                                </div>

                                <div class="col-12">
                                    <input-container-component titulo="Telefone" id="novoTelefone" id-help="novoTelefoneHelp" texto-help="">
                                        <input type="text" class="form-control" id="novoTelefone" aria-describedby="novoTelefoneHelp" placeholder="Telefone" v-mask="'(##)#####-####'" v-model="telefoneCliente">
                                    </input-container-component>
                                </div>

                                <div class="col-12">
                                    <input-container-component titulo="CPF" id="novoCpf" id-help="novoCpfHelp" texto-help="">
                                        <input type="number" class="form-control" id="novoCpf" aria-describedby="novoCpfHelp" placeholder="CPF" v-model="cpfCliente" v-mask="'###.###.###-##'">
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

                <!-- Modal visualizar cliente -->
                <modal-component id="modalclienteVisualizar" titulo="Visualizar cliente">

                    <template v-slot:alertas>

                    </template>

                    <template v-slot:conteudo>

                        <div class="row">

                            <div class="col-12">
                                <input-container-component titulo="Nome">
                                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-12">
                                <input-container-component titulo="Telefone">
                                    <input type="text" class="form-control" :value="$store.state.item.telefone" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-12">
                                <input-container-component titulo="CPF">
                                    <input type="text" class="form-control" :value="$store.state.item.cpf" disabled>
                                </input-container-component>
                            </div>

                        </div>

                    </template>

                    <template v-slot:rodape>
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>-->
                    </template>

                </modal-component>


                <!-- Modal atualização cliente -->
                <modal-component id="modalclienteAtualizar" titulo="Atualizar cliente">

                <template v-slot:alertas>
                    <alert-component v-if="$store.state.transacao.status == 'sucesso'" tipo="success" titulo="cliente atualizado com sucesso." :detalhes="{mensagem: ''}"></alert-component>
                    <alert-component v-if="$store.state.transacao.status == 'erro'" tipo="danger" titulo="Erro ao atualizar cliente." :detalhes="{mensagem: ''}"></alert-component>
                </template>

                <template v-slot:conteudo>

                    <div class="form-group">

                        <div class="row">

                            <input-container-component titulo="Nome do cliente" id="atualizarNome" id-help="atualizarNomeHelp" texto-help="Informe o nome do cliente">
                                <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome do cliente" v-model="$store.state.item.nome">
                            </input-container-component>

                            <input-container-component titulo="Telefone" id="atualizarTelefone" id-help="atualizarTelefoneHelp" texto-help="Informe o telefone do cliente">
                                <input type="text" class="form-control" id="atualizarTelefone" aria-describedby="atualizarTelefoneHelp" placeholder="Telefone" v-model="$store.state.item.telefone" v-mask="'(##)#####-####'">
                            </input-container-component>

                            <input-container-component titulo="CPF" id="atualizarCpf" id-help="atualizarCpfHelp" texto-help="Informe o CPF do cliente">
                                <input type="text" class="form-control" id="atualizarCpf" aria-describedby="atualizarCpfHelp" placeholder="CPF" v-model="$store.state.item.cpf" v-mask="'###.###.###-##'">
                            </input-container-component>

                        </div>

                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>

                </modal-component>


                <!-- Modal remoção de cliente -->
                <modal-component id="modalclienteRemover" titulo="Remover cliente">

                    <template v-slot:alertas>
                        <alert-component v-if="$store.state.transacao.status == 'sucesso'" tipo="success" titulo="cliente removido com sucesso." :detalhes="{mensagem: ''}"></alert-component>
                        <alert-component v-if="$store.state.transacao.status == 'erro'" tipo="danger" titulo="Erro ao remover cliente." :detalhes="{mensagem: ''}"></alert-component>
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
    import Swal from 'sweetalert2';

    export default {

        mounted() {
            this.carregarLista();
        },

        data() {
            return {
                clientes: { data: [] },
                urlFiltro: '',
                urlPaginacao: '',
                nomeCliente: '',
                telefoneCliente: '',
                cpfCliente: '',
                urlBase: 'http://localhost:8000/api/v1/cliente',
                transacaoStatus: '',
                transacaoDetalhes: {},
                busca : { nome: '', telefone: '', cpf: ''}
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
                        this.clientes = response.data;
                        console.log(this.clientes);
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            },

            salvar() {

                let formData = new FormData();

                formData.append('nome', this.nomeCliente);
                formData.append('telefone', this.telefoneCliente);
                formData.append('cpf', this.cpfCliente);

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
                        console.log('cliente atualizado com sucesso:', response);
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = 'Registro do cliente atualizado com sucesso!';
                        this.carregarLista()
                    })
                    .catch(errors => {
                        if (errors.response) {
                            console.log('Erro ao tentar atualizar cliente. Status:', errors.response.status);
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
