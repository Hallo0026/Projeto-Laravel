<template>

    <nav aria-label="Paginacao tabela registros">
        <ul class="pagination">
            <slot></slot>
        </ul>
    </nav>

</template>

<script>

    export default {

    }

</script>

<style scoped>
    .pagination {
        cursor: pointer;
    }

</style>

