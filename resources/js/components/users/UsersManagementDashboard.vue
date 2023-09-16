<template>
    <div class="card mt-3 p-3">
        <div class="card-body pt-4">
            <div class="header">
                <h3>Manage Users</h3>
                <button type="button" class="btn btn-success float-right" data-bs-toggle="modal" data-bs-target="#userModal">
                    New user <i class="fas fa-plus"></i>
                </button>
            </div>
            <table class="table table-hover" v-if="results && results.data">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Since</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-if="results !== null">
                    <tr v-for="user in results.data" key="user.id">
                        <td> {{ user.name }} </td>
                        <td> {{ user.email }} </td>
                        <td> {{ user.created_at }} </td>
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
    <CreateUser></CreateUser>
</template>



<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Paginator from "@/components/utilities/Paginator.vue"
import PaginatorDetails from "@/components/utilities/PaginatorDetails.vue"
import CreateUser from "@/components/users/CreateUser.vue"

export default {
    components: {
        Paginator,
        PaginatorDetails,
        CreateUser
    },
    setup() {
        const results = ref(null)
        const params = { page: 1 }

        function getUsers() {
            axios.get('/data/users', {params: params})
                .then(response => {
                    results.value = response.data.results
                })
                .catch(error => {
                    console.log(error)
                })
        }

        onMounted(getUsers)

        function getPage(event) {
            params.page = event
            getUsers()
        }

        return {
            results,
            getUsers,
            getPage
        }
    }
}
</script>


<style scoped>
    @import '../../../css/app.css';
</style>
