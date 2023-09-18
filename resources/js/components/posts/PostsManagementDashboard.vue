<template>
    <div class="card">
        <div class="card-body">
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
                <colgroup>
                    <col style="width: 30%;" />
                    <col style="width: 40%;" />
                    <col style="width: 20%;" />
                    <col style="width: 8%; min-width: 100px;" />
                </colgroup>
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
                        <td class="tableData"> {{ post.title }} </td>
                        <td class="tableData"> {{ post.description }} </td>
                        <td class="tableData"> {{ post.created_at }} </td>
                        <td> 
                            <div class="icons">
                                <i class="fas fa-eye eyeIcon"></i>
                                <a href='#' class="editIcon" data-bs-toggle="modal" data-bs-target="#editPostModal" @click="selectedPost = post">
                                    <i class="fas fa-edit"></i>  
                                </a>
                                <a href='#' class="trashIcon" @click.prevent="deletePost(post)">
                                    <i class="fas fa-trash-can"></i>  
                                </a>
                            </div>
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
    <EditPost
        v-if="post !== null"
        v-bind:post="selectedPost"
        @post-updated="success_message = 'Successfully edited user: ' + $event">
    </EditPost>
</template>


<script>
    import axios from 'axios'
    import { ref, onMounted } from 'vue'
    import Paginator from "@/components/utilities/Paginator.vue"
    import PaginatorDetails from "@/components/utilities/PaginatorDetails.vue"
    import CreatePost from "@/components/posts/CreatePost.vue"
    import EditPost from './EditPost.vue'

    export default {
        components: {
            Paginator,
            PaginatorDetails,
            CreatePost,
            EditPost
        },
        setup() {
            const results = ref(null)
            const params = ref({ page: 1 })
            const success_message = ref(null)
            const danger_message = ref(null)
            const selectedPost = ref(null)


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
                            success_message.value = "Successfully deleted post: " + post.title + "."
                            setTimeout(() => {
                                success_message.value = null
                            }, 1500)
                        })
                        .catch(error => {
                            if(error.response.status === 403) {
                                danger_message.value = "Unauthorized access."
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
                selectedPost,
                deletePost
            }
        }
    }
</script>


<style>
    @import '../../../css/app.css';
</style>
