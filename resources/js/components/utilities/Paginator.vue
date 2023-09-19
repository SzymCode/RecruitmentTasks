<template>
    <nav class="paginator">
        <ul class="pagination" :style="{ opacity: results.current_page > 1 ? 1 : 0.4, cursor: results.current_page > 1 ? 'pointer' : 'default' }">
            <!-- First page -->
            <li class="page-item" @click.prevent="$emit('get-page', results.first_page)">
                <a class="page-link">
                    <i class="fas fa-chevron-left"></i>
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
            <!-- Previous page -->
            <li class="page-item" @click.prevent="$emit('get-page', results.current_page - 1)">
                <a class="page-link">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        </ul>


        <ul class="pagination">
            <!-- Pagination numbers & dots -->
            <li class="page-item page-dots" v-if="results.current_page > 2">
                <span class="page-link">...</span>
            </li>
            <li class="page-item numbers"
                v-for="num in results.last_page"
                :key="num"
                :class="{ active: num === results.current_page }">
                <a class="page-link" href="#" v-if="num > results. current_page - 2 && num < results.current_page + 2" @click.prevent="$emit('get-page', num)">
                    {{ num }}
                </a>
            </li>
            <li class="page-item page-dots" v-if="results.current_page < results.last_page - 2">
                <span class="page-link">...</span>
            </li>
        </ul>


        <ul class="pagination" :style="{ opacity: results.current_page < results.last_page ? 1 : 0.4, cursor: results.current_page < results.last_page ? 'pointer' : 'default' }">
            <!-- Next page -->
            <li class="page-item"
                @click.prevent="results.current_page < results.last_page && $emit('get-page', results.current_page + 1)">
                <a class="page-link">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>

            <!-- Last page -->
            <li class="page-item" @click.prevent="$emit('get-page', results.last_page)">
                <a class="page-link">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>


<script>
    export default {
        props: ['results'],
    }
</script>