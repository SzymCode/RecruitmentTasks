<template>
    <div class="card mt-3">
        <div class="card-body pt-4">
            <div class="header">
                <h3>Manage Posts</h3>
                <PaginatorDetails
                    v-if="results !== null"
                    v-bind:results="results">
                </PaginatorDetails>
            </div>
            <table class="table table-hover" v-if="results && results.data">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Post Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-if="results !==null">
                    <tr v-for="post in results.data" :key="post.id">
                        <td> {{ post.title }} </td>
                        <td> {{ post.description }} </td>
                        <td> {{ post.created_at }} </td>
                        <td> <i class="fas fa-edit"></i> </td>
                    </tr>
                </tbody>
            </table>
            <div v-else>
                Loading data or no data available...
            </div>
            <Paginator
                v-if="results !== null"
                v-bind:results="results"
                v-on:get-page="getPage">
            </Paginator>
        </div>
    </div>
</template>


<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Paginator from "@/components/utilities/Paginator.vue"
import PaginatorDetails from "@/components/utilities/PaginatorDetails.vue"

export default {
    components: {
        Paginator,
        PaginatorDetails
    },
    setup() {
        const results = ref(null)
        const params = { page: 1 }

        function getPosts() {
            axios.get('/data/posts', {params: params})
                .then(response => {
                    results.value = response.data.results
                })
                .catch(error => {
                    console.log(error)
                })
        }

        onMounted(getPosts)

        function getPage(event) {
            params.page = event
            getPosts()
        }

        return {
            results,
            getPosts,
            getPage
        }
    }
}
</script>