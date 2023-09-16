<template>
    <nav class="paginator">
        <ul class="pagination">
            <!-- First page -->
            <li class="page-item" @click.prevent="$emit('get-page', results.first_page)">
                <a class="page-link" href="#">
                    <i class="fas fa-chevron-left"></i>
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
            <!-- Previous page -->
            <li class="page-item" v-if="results.current_page > 1" @click.prevent="$emit('get-page', results.current_page - 1)">
                <a class="page-link" href="#">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        </ul>


        <ul class="pagination">
            <!-- Pagination numbers & dots -->
            <li class="page-item" v-if="results.current_page > 5">
                <span class="page-link">...</span>
            </li>
            <li class="page-item numbers"
                v-for="num in results.last_page"
                :key="num"
                :class="{ active: num === results.current_page }">
                <a class="page-link" href="#" v-if="num > results. current_page - 5 && num < results.current_page + 5" @click.prevent="$emit('get-page', num)">
                    {{ num }}
                </a>
            </li>
            <li class="page-item" v-if="results.current_page < results.last_page - 5">
                <span class="page-link">...</span>
            </li>
        </ul>


        <ul class="pagination">
            <!-- Next page -->
            <li class="page-item" v-if="results.current_page < results.last_page" @click.prevent="$emit('get-page', results.current_page + 1)">
                <a class="page-link" href="#">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>

            <!-- Last page -->
            <li class="page-item" @click.prevent="$emit('get-page', results.last_page)">
                <a class="page-link" href="#">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>


<style>
    .paginator {
        display: flex;
        justify-content: space-between;
        margin-top: 35px;
    }
</style>


<script>
    export default {
        props: ['results'],
    }
</script>
