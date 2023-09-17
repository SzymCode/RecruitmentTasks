<template>
    <div class="card mt-3 p-3">
        <div class="card-body pt-4">
            <div class="header">
                <h3>Manage Posts</h3>
                <button type="button" class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#postModal">
                    New post <i class="fas fa-plus"></i>
                </button>
            </div>

            <!-- Display success messages -->
            <div class="alert-success alert" role="alert" v-if="success_message !== null">
                {{ success_message }}
            </div>

            <!-- Display danger messages -->
            <div class="alert-danger alert" role="alert" v-if="danger_message !== null">
                {{ danger_message }}
            </div>
            <br>

            <!-- Table -->
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
                        <td> 
                            <i class="fas fa-edit edit-icon"></i>
                            <a href='#' @click.prevent="deletePost(post)">
                                <i class="fas fa-trash-can trash-icon"></i>  
                            </a>
                        </td>
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
            const success_message = ref(null)
            const danger_message = ref(null)


            function getPosts() {
                axios.get('/data/posts', { params: params.value })
                    .then((response) => {
                        results.value = response.data.results
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }

            function getPage(event) {
                params.value.page = event
                getPosts()
            }

            function deletePost(post) {
                let confirm = window.confirm("Are you sure you want to delete " + post.title + " from the system?")
                if (confirm) {
                    axios.post('/data/posts/' + post.id, { _method: 'DELETE'})
                        .then(response => {
                            getPosts()
                            success_message.value = "Successfully deleted post: " + post.title
                            setTimeout(() => {
                                success_message.value = null
                            }, 1500)
                        })
                        .catch(errors => {
                            if(errors.response.status === 403) {
                                danger_message.value = "Unauthorized to access"
                                setTimeout(() => {
                                    danger_message.value = null
                                }, 1500)
                            }
                        })
                }
            }

            onMounted(getPosts)

            return {
                results,
                getPosts,
                getPage,
                success_message,
                danger_message,
                deletePost
            }
        }
    }
</script>



<style scoped>
    @import '../../../css/app.css';
</style>
