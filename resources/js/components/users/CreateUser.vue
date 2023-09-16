<template>
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="userModalLabel">Create new user!</h3>
                    <a href="#" aria-hidden="true" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-close"></i>
                    </a>
                </div>

                <!-- TODO: sometimes errors are not displayed. Fix later. -->
                <div class="alert alert-warning" role="alert" v-if="errors.length > 0">
                    <ul>
                        <li v-for="error in errors">
                            {{ error }}
                        </li>
                    </ul>
                </div>

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
                                <select class="form-control" v-model="data.role">
                                    <option :value="user">User</option>
                                    <option :value="admin">Admin</option>
                                </select>
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

                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" @click.prevent="this.storeUser">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        setup() {
            const data = {
                name: '',
                email: '',
                role: '',
                password: '',
                confirm_password: ''
            }
            const errors = []

            function storeUser() {
                axios.post('/data/users', {
                    name: this.data.name,
                    email: this.data.email,
                    role: this.data.role,
                    password: this.data.password,
                    confirm_password: this.data.confirm_password
                })
                .then(response => console.log(response))
                .catch(errors => {
                    this.flashErrors(errors.response.data.errors)
                })
            }


            function flashErrors(errors) {
                for(const [value] of Object.entries(errors)) {
                    for(let item in value) {
                        this.errors.push(value[item])
                    }
                }
            }

            return {
                data,
                errors,
                storeUser,
                flashErrors
            }
        }
    }
</script>


<style scoped>
    @import '../../../css/app.css';
</style>
