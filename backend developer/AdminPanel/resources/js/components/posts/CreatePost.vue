<template>
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h3 class="modal-title" id="postModalLabel">Create new post!</h3>
                    <a href="#" aria-hidden="true" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-close"></i>
                    </a>
                </div>

                <!-- Display errors -->
                <div class="alert alert-warning" role="alert" v-if="errors.length > 0">
                    <ul>
                        <li v-for="error in errors">
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <!-- Post form -->
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group row">
                            <label class="col-3">Title</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="data.title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Description</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="data.description">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Created At</label>
                            <div class="col-9">
                                <input type="date" class="form-control" v-model="data.created_at">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" @click.prevent="storePost">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { ref } from 'vue'
import axios from 'axios'

export default {
    setup() {
        const data = ref({
            title: '',
            description: '',
            created_at: ''
        })
        const errors = ref([])

        function storePost() {
            errors.value = []
            axios.post('/data/posts', {
                title: data.value.title,
                description: data.value.description,
                created_at: data.value.created_at
            })
                .then((response) => {
                    console.log(response)
                })
                .catch((error) => {
                    for (const key in error.response.data.errors) {
                        errors.value.push(error.response.data.errors[key][0])
                    }
                })
        }

        return {
            data,
            errors,
            storePost
        }
    }
}
</script>


<style scoped>
    @import '../../../css/app.css';
</style>
