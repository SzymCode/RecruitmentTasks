<template>
    <div class="card">
        <div class="card-body">
            <section id="header">
                <div class="header">
                    <h3 class="textHeader">Manage Posts</h3>
                    <button
                        type="button"
                        class="btn btn-success float-right"
                        data-bs-toggle="modal"
                        data-bs-target="#postModal"
                    >
                        New post <i class="fas fa-plus"></i>
                    </button>
                </div>
                <input
                    v-model="searchQuery"
                    @input="performSearch"
                    type="text"
                    class="form-control searchInput"
                    placeholder="Search by title"
                />
            </section>

            <!-- Display success messages -->
            <div class="alert-success alert homeAlert" role="alert" v-if="success_message !== null">
                {{ success_message }}
            </div>

            <!-- Display danger messages -->
            <div class="alert-danger alert homeAlert" role="alert" v-if="danger_message !== null">
                {{ danger_message }}
            </div>
            <br />

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
                        <th class="titleCol titleHeader" @click="sortByColumn('title')">
                            Title 
                            <span v-if="sortBy === 'title:az'">&ensp;▲</span>
                            <span v-if="sortBy === 'title:za'">&ensp;▼</span>
                        </th>
                        <th class="descriptionCol titleHeader" @click="sortByColumn('description')">
                            Description 
                            <span v-if="sortBy === 'description:az'">&ensp;▲</span>
                            <span v-if="sortBy === 'description:za'">&ensp;▼</span>
                        </th>
                        <th class="tagsCol titleHeader" @click="sortByColumn('tags')">
                            Tags 
                            <span v-if="sortBy === 'tags:az'">&ensp;▲</span>
                            <span v-if="sortBy === 'tags:za'">&ensp;▼</span>
                        </th>
                        <th class="postDateCol titleHeader" @click="sortByColumn('created_at')">
                            Post Date 
                            <span v-if="sortBy === 'created_at:az'">&ensp;▲</span>
                            <span v-if="sortBy === 'created_at:za'">&ensp;▼</span>
                        </th>
                        <th class="actionsCol"></th>
                    </tr>
                </thead>
                <tbody v-if="results !== null">
                    <tr v-for="post in sortedPosts" :key="post.id">
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
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#showPostModal" @click.prevent="selectedPost = post">
                                                Details
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editPostModal" @click.prevent="selectedPost = post">
                                                Edit post
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#header" @click="deletePost(post)">
                                                Delete post
                                            </a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="noFoundMessage">
                <div v-if="results && searchQuery && results.data.length === 0">
                    No posts found with title containing "{{ searchQuery }}"
                </div>
                <div v-if="results && results.data.length === 0 && !searchQuery">
                    Loading data or no data available...
                </div>
            </div>
            <Paginator
                v-if="results !== null"
                v-bind:results="results"
                v-on:get-page="getPage"
            ></Paginator>
            <PaginatorDetails
                v-if="results !== null"
                v-bind:results="results"
            ></PaginatorDetails>
        </div>
    </div>
    <CreatePost></CreatePost>
    <EditPost
        v-bind:post="selectedPost"
        @post-updated="success_message = 'Successfully edited user: ' + $event"
    ></EditPost>
    <ShowPost v-bind:post="selectedPost"></ShowPost>
</template>

<script>
    import axios from 'axios'
    import { ref, onMounted, computed } from 'vue'
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
            const searchQuery = ref('')
            const sortBy = ref('tags:az')

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
                            if (error.response.status === 500) {
                                errors.value = ["HTTP 500: Internal Server Error"]
                            }
                            else if (error.response.status === 403 || 401 && !422) {
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
                const trimmedSearchQuery = searchQuery.value.trim();
        
                if (trimmedSearchQuery !== '' || ' ') {
                params.value.title_contains = trimmedSearchQuery;
                getPosts();
                }
            }

            function sortByColumn(column) {
                if (sortBy.value.startsWith(column)) {
                    sortBy.value = sortBy.value.endsWith(':az') ? column + ':za' : column + ':az'
                } 
                else {
                    sortBy.value = column + ':az'
                }
            }

            const sortedPosts = computed(() => {
                if (results.value && results.value.data) {
                    const sortedData = [...results.value.data]
                    const [column, order] = sortBy.value.split(':')
                    sortedData.sort((post1, post2) => {
                        const value1 = column === 'tags' ? (post1[column] || '').toLowerCase() : post1[column]
                        const value2 = column === 'tags' ? (post2[column] || '').toLowerCase() : post2[column]
                        const sortOrder = order === 'az' ? 1 : -1
                        return sortOrder * value1.localeCompare(value2)
                    })
                    return sortedData
                }
                return []
            })

            onMounted(getPosts)

            return {
                results,
                getPosts,
                getPage,
                success_message,
                danger_message,
                selectedPost,
                searchQuery,
                sortBy,
                deletePost,
                sortedPosts,
                sortByColumn,
                performSearch
            }
        }
    }
</script>


<style>
    @import '../../../css/app.css';
</style>
