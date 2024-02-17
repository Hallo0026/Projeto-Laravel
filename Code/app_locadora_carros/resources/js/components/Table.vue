<template>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="t, key in titulos" :key="key">{{ t.titulo }}</th>
            </tr>
        </thead>
        <tbody>

            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj">

                    <span v-if="titulos[chaveValor].tipo == 'texto'"> {{ valor }}</span>
                    <span v-if="titulos[chaveValor].tipo == 'data'"> {{ valor }}</span>
                    <span v-if="titulos[chaveValor].tipo == 'imagem'">
                        <img :src="'/storage/' + valor" width="30" height="30">
                    </span>

                </td>
            </tr>

        </tbody>
    </table>

</template>

<script>

import { format } from 'date-fns';

export default {
    props: ['dados', 'titulos'],
    computed: {
        dadosFiltrados() {

            let dadosFiltrados = [];
            let campos = Object.keys(this.titulos);

            this.dados.map((item, chave) => {
            let itemFiltrado = {};

            campos.forEach(campo => {
                if (this.titulos[campo].tipo === 'data' && item[campo]) {
                // Formatando a data usando date-fns se o tipo do campo for 'data'
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

