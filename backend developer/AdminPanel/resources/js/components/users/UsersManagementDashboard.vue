<template>
    <div class="card mt-3">
        <div class="card-body pt-4">
            <h3>Manage Users</h3>

            <table class="table table-hover" v-if="results && results.data">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Since</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-if="results !==null">
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
        </div>
     </div>   
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const results = ref(null);
        const params = { page: 1 };

        function getUsers() {
            axios.get('/data/users', {params: params})
                .then(response => {
                    results.value = response.data.results;
                })
                .catch(error => {
                    console.log(error);
                });
        };

        onMounted(getUsers);

        return {
            results,
            getUsers
        };
    }
}
</script>