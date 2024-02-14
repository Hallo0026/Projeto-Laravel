<template>

    <div class="card mb-4">
        <div class="card-header">{{ titulo }}</div>

        <div class="card-body">
            <slot name="conteudo"></slot>

        </div> <!-- card-body -->

        <div class="card-footer text-end">
            <slot name="rodape"></slot>
        </div>

    </div> <!-- card  -->

</template>

<script>
    export default {
        props: ['titulo']
    }
</script>
