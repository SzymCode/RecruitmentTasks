<template>
    <div class="card">
        <div class="card-body">
            <div class="header">
                <h3 class="textHeader">Manage Users</h3>
                <button
                    type="button"
                    class="btn btn-success float-right"
                    data-bs-toggle="modal"
                    data-bs-target="#userModal"
                >
                    New user <i class="fas fa-plus"></i>
                </button>
            </div>
            <input
                v-model="searchQuery"
                @input="performSearch"
                type="text"
                class="form-control searchInput"
                placeholder="Search by name"
            />

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
                    <col class="nameCol" />
                    <col class="emailCol" />
                    <col class="createdAtCol" />
                    <col class="actionsCol" />
                </colgroup>
                <thead>
                    <tr>
                        <th class="nameCol titleHeader" @click="sortByColumn('name')">
                            Name
                            <span v-if="sortBy === 'name:az'">&ensp;▲</span>
                            <span v-if="sortBy === 'name:za'">&ensp;▼</span>
                        </th>
                        <th class="emailCol titleHeader" @click="sortByColumn('email')">
                            Email
                            <span v-if="sortBy === 'email:az'">&ensp;▲</span>
                            <span v-if="sortBy === 'email:za'">&ensp;▼</span>
                        </th>
                        <th class="createdAtCol titleHeader" @click="sortByColumn('created_at')">
                            User Since
                            <span v-if="sortBy === 'created_at:az'">&ensp;▲</span>
                            <span v-if="sortBy === 'created_at:za'">&ensp;▼</span>
                        </th>
                        <th class="actionsCol"></th>
                    </tr>
                </thead>
                <tbody v-if="results !== null">
                    <tr v-for="user in sortedUsers" :key="user.id" class="tableData">
                        <td class="tableData nameCol">
                            <div class="overflow-hidden">{{ user.name }}</div>
                        </td>
                        <td class="tableData emailCol">
                            <div class="overflow-hidden">{{ user.email }}</div>
                        </td>
                        <td class="tableData createdAtCol">{{ user.created_at }}</td>
                        <td class="tableData actionsCol">
                            <div class="icons">
                                <a data-bs-toggle="modal" data-bs-target="#showUserModal" @click="selectedUser = user">
                                    <i class="fas fa-eye eyeIcon"></i>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#editUserModal" @click="selectedUser = user">
                                    <i class="fas fa-edit editIcon"></i>
                                </a>
                                <a href="#navbar" @click="deleteUser(user)">
                                    <i class="fas fa-trash-can trashIcon"></i>
                                </a>

                                <a class="ellipsisIcon" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis ellipsisIcon"></i>
                                </a>
                                <div class="dropdown user-dropdown">
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#showUserModal" @click.prevent="selectedUser = user">Details</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal" @click.prevent="selectedUser = user">Edit user</a></li>
                                        <li><a class="dropdown-item" href="#navbar" @click="deleteUser(user)">Delete user</a></li>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="noFoundMessage">
                <div v-if="results && searchQuery && results.data.length === 0">
                    No users found with name containing "{{ searchQuery }}"
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
    <CreateUser></CreateUser>
    <EditUser
        v-bind:user="selectedUser"
        @user-updated="success_message = 'Successfully edited user: ' + $event"
    ></EditUser>
    <ShowUser v-bind:user="selectedUser"></ShowUser>
</template>


<script>
    import { ref, onMounted, computed } from 'vue'
    import axios from 'axios'
    import Paginator from "@/components/utilities/Paginator.vue"
    import PaginatorDetails from "@/components/utilities/PaginatorDetails.vue"
    import CreateUser from "./CreateUser.vue"
    import EditUser from './EditUser.vue'
    import ShowUser from './ShowUser.vue'

    export default {
        components: {
            Paginator,
            PaginatorDetails,
            CreateUser,
            EditUser,
            ShowUser
        },
        setup() {
            const results = ref(null)
            const params = ref({ page: 1 })
            const success_message = ref(null)
            const danger_message = ref(null)
            const selectedUser = ref(null)
            const searchQuery = ref('')
            const sortBy = ref('name:az')

            function getUsers() {
                axios.get('/data/users', { params: params.value })
                    .then(response => {
                        results.value = response.data.results
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }

            function getPage(event) {
                params.value.page = event
                getUsers()
            }

            function performSearch() {
                params.value.page = 1
                console.log(params.value)
                const trimmedSearchQuery = searchQuery.value.trim()

                if (trimmedSearchQuery !== ' ' || '') {
                    params.value.name_contains = trimmedSearchQuery
                    getUsers()
                }
            }

            function deleteUser(user) {
                let confirm = window.confirm("Are you sure you want to delete " + user.name + " from the system?")
                if (confirm) {
                    axios.post('/data/users/' + user.id, { _method: 'DELETE'})
                        .then(response => {
                            getUsers()
                            success_message.value = "Successfully deleted user: " + user.name + "."
                            setTimeout(() => {
                                success_message.value = null
                            }, 1500)
                        })
                        .catch(error => {
                            if (error.response.status === 500) {
                                danger_message.value = "HTTP 500: Internal Server Error"
                            }
                            else if (error.response.status === 403 || error.response.status === 401 || error.response.status === 422) {
                                danger_message.value = "Unauthorized access."
                            }
                            setTimeout(() => {
                                danger_message.value = null
                            }, 1500)
                        })
                }
            }

            function sortByColumn(column) {
                if (sortBy.value.startsWith(column)) {
                    sortBy.value = sortBy.value.endsWith(':az') ? column + ':za' : column + ':az'
                } else {
                    sortBy.value = column + ':az'
                }
            }

            const sortedUsers = computed(() => {
                if (results.value && results.value.data) {
                    const sortedData = [...results.value.data]
                    const [column, order] = sortBy.value.split(':')
                    sortedData.sort((user1, user2) => {
                        const value1 = column === 'name' ? user1[column] : column === 'email' ? user1[column] : user1['created_at']
                        const value2 = column === 'name' ? user2[column] : column === 'email' ? user2[column] : user2['created_at']
                        const sortOrder = order === 'az' ? 1 : -1
                        return sortOrder * value1.localeCompare(value2)
                    })
                    return sortedData
                }
                return []
            })

            onMounted(getUsers)

            return {
                results,
                getUsers,
                getPage,
                success_message,
                danger_message,
                selectedUser,
                searchQuery,
                deleteUser,
                performSearch,
                sortBy,
                sortByColumn,
                sortedUsers
            }
        }
    }
</script>


<style>
    @import '../../../css/app.css';
</style>
