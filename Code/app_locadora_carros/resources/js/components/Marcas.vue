<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <card-component titulo="Buscar marcas"> <!-- Card de busca -->

                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col-4 mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-help="Informe o ID da marca">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col-8 mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-help="Informe o nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome">
                                </input-container-component>
                            </div>
                        </div> <!-- row -->

                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
                    </template>

                </card-component> <!-- Fim card de busca -->


                <card-component titulo="Relação de marcas"> <!-- Card relações de marcas -->

                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                    </template>

                </card-component> <!-- Fim card relação de marcas -->


                <!-- Modal -->
                <modal-component id="modalMarca" titulo="Adicionar marca">

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

        data() {
            return {
                urlBase: 'http://localhost:8000/api/v1/marca',
                nomeMarca: '',
                arquivoImagem: []
            }
        },

        methods: {
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
                        console.log(response);
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
</style>
