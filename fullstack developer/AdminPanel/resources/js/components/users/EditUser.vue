<template>
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h3 class="modal-title" id="editUserModalLabel">Edit user: {{ data.display_name }}</h3>
                </div>

                <!-- Display success messages-->
                <div class="alert-success alert" role="alert" v-if="success_message !== null">
                    {{ success_message }}
                </div>

                <!-- Display danger messages -->
                <div class="alert-danger alert" role="alert" v-if="danger_message !== null">
                    {{ danger_message }}
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

                        <!-- Buttons -->
                        <div class="modal-footer">
                            <!-- @click.prevent="" prevents scrolling up after close modal -->
                            <button class="btn btn-dark" @click.prevent="" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" @click.prevent="updateUser">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
    import axios from 'axios'
    import { ref, toRefs, watch } from 'vue'

    export default {
        props: ['user'],
        setup(props) {
            const { user } = toRefs(props)

            const data = ref({ })

            const errors = ref([])
            const success_message = ref(null)
            const danger_message = ref(null)

            function assignPropsToData() {
                Object.assign(data.value, user.value)
                data.value.display_name = data.value.name
            }

            function updateUser() {
                errors.value = []
                axios.post('data/users/' + user.value.id, {
                    _method: 'PUT',
                    name: data.value.name,
                    email: data.value.email,
                    role: data.value.role,
                    display_name: data.value.name
                })
                    .then((response) => {
                        success_message.value = "Successfully edited user: " + data.value.name + "."
                        setTimeout(() => {
                            success_message.value = null
                            location.reload()
                        }, 1500)
                    })
                    .catch((error) => {
                        if (error.response.status === 500) {
                            errors.value = ["This email has already been taken."]
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

            watch(user, () => {
                assignPropsToData()
            }), { deep: true }

            return {
                data,
                errors,
                success_message,
                danger_message,
                updateUser
            }
        }
    }
</script>
