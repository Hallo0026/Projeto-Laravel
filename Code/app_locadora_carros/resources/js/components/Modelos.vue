<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Buscar modelos"> <!-- Card de busca -->

                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col-4 mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-help="Opcional. Informe o ID do modelo">
                                    <input v-model="busca.id" type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col-8 mb-3">
                                <input-container-component titulo="Nome do modelo" id="inputNome" id-help="nomeHelp" texto-help="Opcional. Informe o nome do modelo">
                                    <input v-model="busca.nome" type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome">
                                </input-container-component>
                            </div>
                        </div> <!-- row -->

                    </template>

                    <template v-slot:rodape>
                        <button @click="pesquisar()" class="btn btn-primary btn-sm">Pesquisar</button>
                    </template>

                </card-component> <!-- Fim card de busca -->


                <card-component titulo="Relação de modelos"> <!-- Card relações de modelos -->

                    <template v-slot:conteudo>

                        <table-component
                            :dados="modelos.data"
                            :visualizar = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalmodeloVisualizar' }"
                            :atualizar = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalmodeloAtualizar' }"
                            :remover = "{ visivel: true, dataBsToggle: 'modal', dataBsTarget: '#modalmodeloRemover' }"
                            :titulos=" {
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                marca: {titulo: 'Marca', tipo: 'texto'},
                                air_bag: {titulo: 'Airbags', tipo: 'texto'},
                                abs: {titulo: 'ABS', tipo: 'texto'},
                                numero_portas: {titulo: 'Portas', tipo: 'texto'},
                                lugares: {titulo: 'Lugares', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'}
                            }"
                        ></table-component>

                    </template>

                    <template v-slot:rodape>

                        <div class="row">

                            <div class="col-8">
                                <!--<paginate-component
                                :dados="modelos"
                                @paginar="carregarLista"
                                ></paginate-component>-->
                                <paginate-component>
                                    <li v-for="l, key in modelos.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col-4">
                                <button type="button" class="btn btn-primary btn-adicionar btn-sm" data-bs-toggle="modal" data-bs-target="#modalmodelo">Adicionar</button>
                            </div>

                        </div>

                    </template>

                </card-component> <!-- Fim card relação de modelos -->


                <!-- Modal adicionar modelo -->
                <modal-component id="modalmodelo" titulo="Adicionar modelo">

                    <template v-slot:alertas>
                        <alert-component titulo="Cadastro realizado com sucesso!" tipo="success" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'adicionado'"></alert-component>
                        <alert-component titulo="Erro ao tentar cadastrar a modelo" tipo="danger" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'erro'"></alert-component>
                    </template>

                    <template v-slot:conteudo>

                        <div class="form-group">

                            <div class="row">

                                <div class="col-12">
                                    <input-container-component titulo="Nome do modelo" id="novoNome" id-help="novoNomeHelp" texto-help="Informe o nome do modelo">
                                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome do modelo" v-model="nomemodelo">
                                    </input-container-component>
                                </div>

                                <div class="col-12">
                                    <input-container-component titulo="Nome da marca" id="novoNomeMarca" id-help="novoNomeMarcaHelp" texto-help="Informe a marca do modelo">
                                        <select id="novoNomeMarca" class="form-select">
                                            <option value="" disabled selected>Selecione uma marca</option>
                                            <option v-for="marca in marcas" :value="marca.id">{{ marca.nome }}</option>
                                        </select>
                                    </input-container-component>
                                </div>

                                <div class="col-12">
                                    <input-container-component titulo="Imagem" id="novaImagem" id-help="novaImagemHelp" texto-help="Selecione uma imagem no formato PNG">
                                        <input type="file" class="form-control" id="novaImagem" aria-describedby="novaImagem" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                                        <!-- Onchange pois não é possível utilizar v-on em inputs type file -->
                                    </input-container-component>
                                </div>

                                <div class="col-6">
                                    <input-container-component titulo="Numero de portas" id="novoNumeroPortas" id-help="novoNumeroPortasHelp" texto-help="Informe a quantidade de portas do modelo">
                                        <input type="number" class="form-control" id="novoNumeroPortas" aria-describedby="novoNumeroPortasHelp" placeholder="Número de portas" v-model="numeroPortas">
                                    </input-container-component>
                                </div>

                                <div class="col-6">
                                    <input-container-component titulo="Lugares" id="novoLugares" id-help="novoLugaresHelp" texto-help="Quantidade de lugares">
                                        <input type="number" class="form-control" id="novoLugares" aria-describedby="novoLugaresHelp" placeholder="Lugares" v-model="lugares">
                                    </input-container-component>
                                </div>

                                <div class="col-6">
                                    <input-container-component titulo="Possui ABS" id="novoAbs" id-help="novoAbsHelp" texto-help="O modelo possui freios ABS?">
                                        <select id="novoAbs" class="form-select" v-model="abs">
                                            <option value="" disabled selected>Selecione uma opção</option>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </input-container-component>
                                </div>

                                <div class="col-6">
                                    <input-container-component titulo="Possui Airbags" id="novoAirbags" id-help="novoAirbagsHelp" texto-help="O modelo possui airbags?">
                                        <select id="novoAirbags" class="form-select" v-model="air_bag">
                                            <option value="" disabled selected>Selecione uma opção</option>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </input-container-component>
                                </div>

                            </div>

                        </div>

                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                    </template>

                </modal-component>

                <!-- Modal visualizar modelo -->
                <modal-component id="modalmodeloVisualizar" titulo="Visualizar modelo">

                    <template v-slot:alertas>

                    </template>

                    <template v-slot:conteudo>

                        <div class="row">

                            <div class="col-3">
                                <input-container-component titulo="ID">
                                    <input type="number" class="form-control" :value="$store.state.item.id" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-9">
                                <input-container-component titulo="Nome">
                                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-12">
                                <input-container-component titulo="Marca">
                                    <input type="text" class="form-control" :value="$store.state.item.marca ? $store.state.item.marca.nome : ''" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-12">
                                <input-container-component titulo="Imagem">
                                    <div>
                                        <img :src="'/storage/' + $store.state.item.imagem" v-if="$store.state.item.imagem" width="100">
                                    </div>
                                </input-container-component>
                            </div>

                            <div class="col-6">
                                <input-container-component titulo="Numero de portas">
                                    <input type="number" class="form-control" :value="$store.state.item.numero_portas" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-6">
                                <input-container-component titulo="Lugares">
                                    <input type="number" class="form-control" :value="$store.state.item.lugares" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-6">
                                <input-container-component titulo="Possui ABS">
                                    <input type="text" class="form-control" :value="$store.state.item.abs == 1 ? 'Sim' : 'Não'" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-6">
                                <input-container-component titulo="Possui Airbags">
                                    <input type="text" class="form-control" :value="$store.state.item.air_bag == 1 ? 'Sim' : 'Não'" disabled>
                                </input-container-component>
                            </div>

                            <div class="col-12">
                                <input-container-component titulo="Data de criação">
                                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                                </input-container-component>
                            </div>

                        </div>

                    </template>

                    <template v-slot:rodape>
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>-->
                    </template>

                </modal-component>


                <!-- Modal atualização modelo -->
                <modal-component id="modalmodeloAtualizar" titulo="Atualizar modelo">

                <template v-slot:alertas>
                    <alert-component v-if="$store.state.transacao.status == 'sucesso'" tipo="success" titulo="Modelo atualizado com sucesso." :detalhes="{mensagem: ''}"></alert-component>
                    <alert-component v-if="$store.state.transacao.status == 'erro'" tipo="danger" titulo="Erro ao atualizar modelo." :detalhes="{mensagem: ''}"></alert-component>
                </template>

                <template v-slot:conteudo>

                    <div class="form-group">

                        <div class="row">

                            <input-container-component titulo="Nome do modelo" id="atualizarNome" id-help="atualizarNomeHelp" texto-help="Informe o nome do modelo">
                                <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome do modelo" v-model="$store.state.item.nome">
                            </input-container-component>

                            <input-container-component titulo="Marca" id="atualizarMarca" id-help="atualizarMarcaHelp" texto-help="Selecione uma imagem no formato PNG">
                                <select id="atualizarMarca" class="form-select" v-model="$store.state.item.marca_id">
                                    <option value="" disabled>Selecione uma marca</option>
                                    <option v-for="marca in marcas" :key="marca.id" :value="marca.id" :selected="isSelected(marca.id)">{{ marca.nome }}</option>
                                </select>
                            </input-container-component>


                            <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-help="Selecione uma imagem no formato PNG">
                                <input type="file" class="form-control" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                                <!-- Onchange pois não é possível utilizar v-on em inputs type file -->
                            </input-container-component>

                            <div class="col-6">
                                <input-container-component titulo="Numero de portas" id="atualizarNumeroPortas" id-help="atualizarNumeroPortasHelp" texto-help="Informe a quantidade de portas do modelo">
                                    <input type="number" class="form-control" id="atualizarNumeroPortas" aria-describedby="atualizarNumeroPortasHelp" placeholder="Número de portas" v-model="$store.state.item.numero_portas">
                                </input-container-component>
                            </div>

                            <div class="col-6">
                                <input-container-component titulo="Lugares" id="atualizarLugares" id-help="atualizarLugaresHelp" texto-help="Quantidade de lugares">
                                    <input type="number" class="form-control" id="atualizarLugares" aria-describedby="natualizarugaresHelp" placeholder="Lugares" v-model="$store.state.item.lugares">
                                </input-container-component>
                            </div>

                            <div class="col-6">
                                <input-container-component titulo="Possui ABS" id="atualizarAbs" id-help="atualizarAbsHelp" texto-help="O modelo possui freios ABS?">
                                    <select id="atualizarAbs" class="form-select" v-model="$store.state.item.abs">
                                        <option value="" disabled selected>Selecione uma opção</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </input-container-component>
                            </div>

                            <div class="col-6">
                                <input-container-component titulo="Possui Airbags" id="atualizarAirbags" id-help="atualizarAirbagsHelp" texto-help="O modelo possui airbags?">
                                    <select id="atualizarAirbags" class="form-select" v-model="$store.state.item.air_bag">
                                        <option value="" disabled selected>Selecione uma opção</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </input-container-component>
                            </div>

                        </div>

                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>

                </modal-component>


                <!-- Modal remoção de modelo -->
                <modal-component id="modalmodeloRemover" titulo="Remover modelo">

                    <template v-slot:alertas>
                        <alert-component v-if="$store.state.transacao.status == 'sucesso'" tipo="success" titulo="Modelo removido com sucesso." :detalhes="{mensagem: ''}"></alert-component>
                        <alert-component v-if="$store.state.transacao.status == 'erro'" tipo="danger" titulo="Erro ao remover modelo." :detalhes="{mensagem: ''}"></alert-component>
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
    import Swal from 'sweetalert2'

    export default {

        mounted() {
            this.carregarLista();
            this.getMarcas();
        },

        data() {
            return {
                marcas: { data: [] },
                modelos: { data: [] },
                urlFiltro: '',
                urlPaginacao: '',
                urlBase: 'http://localhost:8000/api/v1/modelo',
                nomemodelo: '',
                numeroPortas: '',
                lugares: '',
                abs: '',
                air_bag: '',
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
                        this.modelos = response.data;
                        console.log(this.modelos);
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

                formData.append('nome', this.nomemodelo);
                formData.append('imagem', this.arquivoImagem[0]); // índice 0 pois é esperado trabalhar com um único arquivo
                formData.append('marca_id', document.getElementById('novoNomeMarca').value);
                formData.append('numero_portas', this.numeroPortas);
                formData.append('lugares', this.lugares);
                formData.append('abs', this.abs);
                formData.append('air_bag', this.air_bag);


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
                formData.append('nome', this.$store.state.item.nome);
                formData.append('marca_id', this.$store.state.item.marca_id);
                formData.append('numero_portas', this.$store.state.item.numero_portas);
                formData.append('lugares', this.$store.state.item.lugares);
                formData.append('abs', this.$store.state.item.abs);
                formData.append('air_bag', this.$store.state.item.air_bag);

                if(this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0]);
                }

                axios.post(url, formData, config)
                    .then(response => {
                        console.log('modelo atualizada com sucesso:', response);
                        atualizarImagem.value = '';
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = 'Registro de modelo atualizado com sucesso!';
                        this.carregarLista();
                    })
                    .catch(errors => {
                        if (errors.response) {
                            console.log('Erro ao tentar atualizar modelo. Status:', errors.response.status);
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

            getMarcas() {
                let url = 'http://localhost:8000/api/v1/marca/false';

                axios.get(url)
                    .then(response => {
                        this.marcas = response.data;
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            },

            isSelected(marcaId) {
                return marcaId === this.$store.state.item.marca_id;
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
