<template>
    <div class="card">
        <div class="card-body">
            <section id="header">
                <div class="header">
                    <h3>Manage Posts</h3>
                    <button type="button" class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#postModal">
                        New post <i class="fas fa-plus"></i>
                    </button>
                </div>
            </section>

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
                    <col class="titleCol" />
                    <col class="descriptionCol" />
                    <col class="tagsCol" />
                    <col class="postDateCol" />
                    <col class="actionsCol" />
                </colgroup>
                <thead>
                    <tr>
                        <th class="titleCol">Title</th>
                        <th class="descriptionCol">Description</th>
                        <th class="tagsCol">Tags</th>
                        <th class="postDateCol">Post Date</th>
                        <th class="actionsCol"></th>
                    </tr>
                </thead>
                <tbody v-if="results !==null">
                    <tr v-for="post in results.data" :key="post.id">
                        <td class="tableData titleCol"> {{ post.title }} </td>
                        <td class="tableData descriptionCol"> {{ post.description }} </td>
                        <td class="tableData tagsCol"> 
                            <div v-if="post.tags && post.tags.length > 0" class="tags">
                                <div v-for="tag in post.tags.split(', ')" :key="tag" class="tag">
                                    {{ tag }}
                                </div>
                            </div> 
                        </td>
                        <td class="tableData postDateCol"> {{ post.created_at }} </td>
                        <td class="tableData actionsCol"> 
                            <div class="icons">
                                <!-- @media (min-width: 1280px) -->                                
                                <a data-bs-toggle="modal" data-bs-target="#showPostModal" @click="selectedPost = post">
                                    <i class="fas fa-eye eyeIcon"></i>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#editPostModal" @click="selectedPost = post">
                                    <i class="fas fa-edit editIcon"></i>  
                                </a>
                                <a href="#header" @click="deletePost(post)">
                                    <i class="fas fa-trash-can trashIcon"></i>  
                                </a>

                                <!-- @media (max-width: 1280px) -->
                                <a class="ellipsisIcon" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis ellipsisIcon"></i>
                                </a>
                                <div class="dropdown post-dropdown">    
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#showPostModal" @click.prevent="selectedPost = post">
                                            Details
                                        </a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editPostModal" @click.prevent="selectedPost = post">
                                            Edit post
                                        </a></li>
                                        <li><a class="dropdown-item" href="#header" @click="deletePost(post)">
                                            Delete post
                                        </a></li>
                                    </div>
                                </div>
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
        v-bind:post="selectedPost"
        @post-updated="success_message = 'Successfully edited user: ' + $event">
    </EditPost>
    <ShowPost
        v-bind:post="selectedPost">
    </ShowPost>
</template>


<script>
    import axios from 'axios'
    import { ref, onMounted } from 'vue'
    import Paginator from "@/components/utilities/Paginator.vue"
    import PaginatorDetails from "@/components/utilities/PaginatorDetails.vue"

    import CreatePost from "./CreatePost.vue"
    import EditPost from './EditPost.vue'
    import ShowPost from './ShowPost.vue'

    export default {
        components: {
            Paginator,
            PaginatorDetails,
            CreatePost,
            EditPost,
            ShowPost
        },
        setup() {
            const results = ref(null)
            const params = ref({ page: 1 })
            const success_message = ref(null)
            const danger_message = ref(null)
            const selectedPost = ref(null)
            const searchQuery = ref('');


            function getPosts() {
                axios.get('/data/posts', { params: params.value })
                    .then((response) => {
                        results.value = response.data.results
                        console.log(response)
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
            
            function performSearch() {
                params.value.page = 1;
                params.value.search = searchQuery.value;
                getPosts();
            }
            onMounted(getPosts)

            return {
                results,
                getPosts,
                getPage,
                success_message,
                danger_message,
                selectedPost,
                searchQuery,
                deletePost,
                performSearch
            }
        }
    }
</script>


<style>
    @import '../../../css/app.css';
</style>
