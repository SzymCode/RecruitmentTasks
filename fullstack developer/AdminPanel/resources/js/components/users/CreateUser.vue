<template>
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true" @keydown.enter.prevent="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h3 class="modal-title" id="userModalLabel">Create new user!</h3>
                </div>

                <!-- Display success messages-->
                <div class="alert-success alert modalAlerts" role="alert" v-if="success_message !== null">
                    {{ success_message }}
                </div>

                <!-- Display danger messages -->
                <div class="alert-danger alert modalAlerts" role="alert" v-if="danger_message !== null">
                    {{ danger_message }}
                </div>

                <!-- Display errors -->
                <div class="alert alert-warning modalAlerts" role="alert" v-if="errors.length > 0">
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
                            <label class="col-4">Name</label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="data.name" @keyup.enter="storeUser">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Email</label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="data.email" @keyup.enter="storeUser">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Role</label>
                            <div class="col-8">
                                <input type="text" class="form-control" v-model="data.role" @keyup.enter="storeUser">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Password</label>
                            <div class="col-8">
                                <input type="password" class="form-control" v-model="data.password" @keyup.enter="storeUser">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4">Confirm Password</label>
                            <div class="col-8">
                                <input type="password" class="form-control" v-model="data.confirm_password" @keyup.enter="storeUser">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="modal-footer">
                            <!-- @click.prevent="" prevents scrolling up after close modal -->
                            <button class="btn btn-dark" @click.prevent="" data-bs-dismiss="modal">Close</button>
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
            const data = ref({})
            const errors = ref([])
            const success_message = ref(null)
            const danger_message = ref(null)

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
                        success_message.value = "Successfully created user: " + response.data.user.name + "."
                        setTimeout(() => {
                            success_message.value = null
                            location.reload()
                        }, 1500)
                    })
                    .catch((error) => {
                        if (error.response.status === 500) {
                            errors.value = ["HTTP 500: Internal Server Error"]
                        }
                        else if (error.response.status === 403 || 401 && !422) {
                            danger_message.value = "Unauthorized access."
                            setTimeout(() => {
                                danger_message.value = null
                            }, 1500)
                        }
                        else if (error.response.status === 422) {
                            for (const key in error.response.data.errors) {
                                errors.value.push(error.response.data.errors[key][0])
                            }
                        }
                    })
            }

            return {
                data,
                errors,
                success_message,
                danger_message,
                storeUser
            }
        }
    }
</script>

