<template>
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h3 class="modal-title" id="userModalLabel">Create new user!</h3>
                    <a href="#" aria-hidden="true" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-close"></i>
                    </a>
                </div>

                <!-- Display success messages-->
                <div class="alert-success alert" role="alert" v-if="success_message !== null">
                    {{ success_message }}
                </div>
    
                <!-- Display errors -->
                <div class="alert alert-warning" role="alert" v-if="errors.length > 0">
                    <ul>
                        <li v-for="error in errors">
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <!-- User form -->
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group row">
                            <label class="col-3">Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="data.name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Email</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="data.email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Role</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="data.role">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Password</label>
                            <div class="col-9">
                                <input type="password" class="form-control" v-model="data.password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Confirm Password</label>
                            <div class="col-9">
                                <input type="password" class="form-control" v-model="data.confirm_password">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" @click.prevent="storeUser">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { ref } from 'vue'

    export default {
        setup() {
            const data = ref({
                name: '',
                email: '',
                role: '',
                password: '',
                confirm_password: ''
            })
            const errors = ref([])
            const success_message = ref(null)
            

            function flashSuccess(message) {
                success_message.value = message
                setTimeout(() => {
                    location.reload()
                }, 2000)
            }
            
            function storeUser() {
                errors.value = []
                axios.post('/data/users', {
                    name: data.value.name,
                    email: data.value.email,
                    role: data.value.role,
                    password: data.value.password,
                    confirm_password: data.value.confirm_password
                })
                    .then((response) => {
                        flashSuccess('Successfully created user: ' + response.data.user.name)
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
                storeUser,
                success_message
            }
        }
    }
</script>


<style scoped>
    @import '../../../css/app.css';
</style>
