<template>
    <div class="card mt-3">
        <div class="card-body pt-4">
            <h3>Manage Posts</h3>

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

        function getPosts() {
            axios.get('/data/posts', {params: params})
                .then(response => {
                    results.value = response.data.results;
                })
                .catch(error => {
                    console.log(error);
                });
        };

        onMounted(getPosts);

        return {
            results,
            getPosts
        };
    }
}
</script>
