<template>
    <div class="card">
        <div class="card-body">
            <div class="header">
                <h3>Manage Users</h3>
                <button type="button" class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#userModal">
                    New user <i class="fas fa-plus"></i>
                </button>
            </div>

            <!-- Display success messages-->
            <div class="alert-success alert" role="alert" v-if="success_message !== null">
                {{ success_message }}
            </div>

            <!-- Display danger messages-->
            <div class="alert-danger alert" role="alert" v-if="danger_message !== null">
                {{ danger_message }}
            </div>
            <br>

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
                        <th class="nameCol">Name</th>
                        <th class="emailCol">Email</th>
                        <th class="createdAtCol">User Since</th>
                        <th class="actionsCol"></th>
                    </tr>
                </thead>
                <tbody v-if="results !== null">
                    <tr v-for="user in results.data" key="user.id" class="tableData">
                        <td class="tableData nameCol"> {{ user.name }} </td>
                        <td class="tableData emailCol"> {{ user.email }} </td>
                        <td class="tableData createdAtCol"> {{ user.created_at }} </td>
                        <td class="tableData actionsCol"> 
                            <div class="icons">
                                <i class="fas fa-eye eyeIcon"></i>
                                <a href='#' class="editIcon" data-bs-toggle="modal" data-bs-target="#editUserModal" @click="selectedUser = user">
                                    <i class="fas fa-edit"></i>  
                                </a>
                                <a href='#' class="trashIcon" @click.prevent="deleteUser(user)">
                                    <i class="fas fa-trash-can"></i>  
                                </a>
                                <i class="fas fa-ellipsis ellipsisIcon"></i>
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
    <CreateUser></CreateUser>
    <EditUser
        v-if="user !== null"
        v-bind:user="selectedUser"
        @user-updated="success_message = 'Successfully edited user: ' + $event">
    </EditUser>
</template>


<script>
    import { ref, onMounted } from 'vue'
    import axios from 'axios'
    import Paginator from "@/components/utilities/Paginator.vue"
    import PaginatorDetails from "@/components/utilities/PaginatorDetails.vue"
    import CreateUser from "@/components/users/CreateUser.vue"
    import EditUser from './EditUser.vue'

    export default {
        components: {
            Paginator,
            PaginatorDetails,
            CreateUser,
            EditUser
        },
        setup() {
            const results = ref(null)
            const params = ref({ page: 1 })
            const success_message = ref(null)
            const danger_message = ref(null)
            const selectedUser = ref(null)


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
                        .catch(errors => {
                            if(errors.response.status === 403) {
                                danger_message.value = "Unauthorized access."
                                setTimeout(() => {
                                    danger_message.value = null
                                }, 1500)
                            }
                        })
                }
            }
            
            onMounted(getUsers)

            return {
                results,
                getUsers,
                getPage,
                success_message,
                danger_message,
                selectedUser,
                deleteUser
            }
        }
    }
</script>


<style>
    @import '../../../css/app.css';
</style>
