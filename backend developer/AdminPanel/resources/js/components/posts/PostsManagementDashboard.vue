<template>
    <div class="card mt-3 p-3">
        <div class="card-body pt-4">
            <div class="header">
                <h3>Manage Posts</h3>
                <button type="button" class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#postModal">
                    New post <i class="fas fa-plus"></i>
                </button>
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
            <PaginatorDetails
                v-if="results !== null"
                v-bind:results="results">
            </PaginatorDetails>
        </div>
    </div>
    <CreatePost></CreatePost>
</template>


<script>
    import axios from 'axios'
    import { ref, onMounted } from 'vue'
    import Paginator from "@/components/utilities/Paginator.vue"
    import PaginatorDetails from "@/components/utilities/PaginatorDetails.vue"
    import CreatePost from "@/components/posts/CreatePost.vue"

    export default {
        components: {
            Paginator,
            PaginatorDetails,
            CreatePost
        },
        setup() {
            const results = ref(null)
            const params = ref({ page: 1 })

            function getPosts() {
                axios.get('/data/posts', { params: params.value })
                    .then((response) => {
                        results.value = response.data.results
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }

            onMounted(getPosts)

            function getPage(event) {
                params.value.page = event
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



<style scoped>
    @import '../../../css/app.css';
</style>
