<template>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titulos" :key="key">{{ t.titulo }}</th>
                <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
            </tr>
        </thead>
        <tbody>

            <tr v-for="obj, chave in dadosFiltrados" :key="chave">

                <td v-for="(valor, chaveValor) in obj">
                    <span v-if="chaveValor === 'marca' && titulos[chaveValor].tipo === 'texto'">{{ valor.nome }}</span>
                    <span v-else-if="chaveValor === 'modelo' && titulos[chaveValor].tipo === 'texto'">{{ valor.nome }}</span>

                    <span v-else-if="chaveValor === 'abs' && valor == 1">Sim</span>
                    <span v-else-if="chaveValor === 'abs' && valor == 0">Não</span>

                    <span v-else-if="chaveValor === 'air_bag' && valor == 1">Sim</span>
                    <span v-else-if="chaveValor === 'air_bag' && valor == 0">Não</span>

                    <span v-else-if="chaveValor === 'disponivel' && valor == 1">Sim</span>
                    <span v-else-if="chaveValor === 'disponivel' && valor == 0">Não</span>

                    <span v-else-if="titulos[chaveValor].tipo === 'texto'">{{ valor }}</span>
                    <span v-else-if="titulos[chaveValor].tipo === 'data'">{{ valor }}</span>
                    <span v-else-if="titulos[chaveValor].tipo === 'imagem'">
                        <img :src="'/storage/' + valor" width="30" height="30">
                    </span>
                </td>


                <td class="td-botoes" v-if="visualizar.visivel || atualizar.visivel || remover.visivel">

                    <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="visualizar.dataBsToggle" :data-bs-target="visualizar.dataBsTarget" @click="setStore(obj)">Visualizar</button>

                    <button v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="atualizar.dataBsToggle" :data-bs-target="atualizar.dataBsTarget" @click="setStore(obj)">Atualizar</button>

                    <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-bs-toggle="remover.dataBsToggle" :data-bs-target="remover.dataBsTarget" @click="setStore(obj)">Remover</button>

                </td>

            </tr>

        </tbody>
    </table>

</template>

<script>

    import { format } from 'date-fns';

    export default {
        props: ['dados', 'titulos', 'visualizar', 'atualizar', 'remover'],
        methods: {
            setStore(obj) {
                this.$store.state.transacao.status = '';
                this.$store.state.transacao.mensagem = '';
                this.$store.state.item = obj;
                console.log(obj);
            }
        },
        computed: {
            dadosFiltrados() {
                let dadosFiltrados = [];
                let campos = Object.keys(this.titulos);

                this.dados.map(item => {
                    let itemFiltrado = {};

                    campos.forEach(campo => {
                        if (this.titulos[campo].tipo === 'data' && item[campo]) {
                            // Formatando a data usando date-fns se o tipo do campo for 'data'
                            //itemFiltrado[campo] = format(new Date(item[campo]), 'dd/MM/yyyy HH:mm:ss');
                            itemFiltrado[campo] = format(new Date(item[campo]), 'dd/MM/yyyy');
                        } else {
                            itemFiltrado[campo] = item[campo];
                        }
                    });

                    dadosFiltrados.push(itemFiltrado);
                });

                return dadosFiltrados;
            }
        }
    };

</script>

<style scoped>

    .btn {
        margin-right: 6px;
    }

    .td-botoes {
        text-align: right;
    }

</style>

