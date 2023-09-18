<template>
    <div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h3 class="modal-title" id="editPostModalLabel">Edit post: {{ data.display_title }}</h3>
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
                            <label class="col-3">Post Date</label>
                            <div class="col-9">
                                <input type="text" class="form-control" v-model="data.created_at">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" @click.prevent="updatePost">Save changes</button>
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
        props: ['post'],
        setup(props) {
            const { post } = toRefs(props)

            const data = ref({
                title: '',
                description: '',
                created_at: '',
                display_title: ''
            })

            const errors = ref([])
            const success_message = ref(null)
            const danger_message = ref(null)

            function assignPropsToData() {
                Object.assign(data.value, post.value)
                data.value.display_title = data.value.title
            }

            function updatePost() {
                errors.value = []
                axios.post('data/posts/' + post.value.id, {
                    _method: 'PUT',
                    title: data.value.title,
                    description: data.value.description,
                    created_at: data.value.created_at,
                    display_title: data.value.title
                })
                    .then((response) => {
                        success_message.value = "Successfully edited post: " + data.value.title + "."
                        setTimeout(() => {
                            success_message.value = null
                            location.reload()
                        }, 1500)
                    })
                    .catch((error) => {
                        if(error.response.status === 403) {
                            danger_message.value = "Unauthorized access."
                            setTimeout(() => {
                                danger_message.value = null
                            }, 1500)
                        }
                        if (error.response.status === 422) {
                            for (const key in error.response.data.errors) {
                                errors.value.push(error.response.data.errors[key][0])
                            }
                        }
                    })
            }

            watch(post, () => {
                assignPropsToData()
            }), { deep: true }

            return {
                data,
                errors,
                success_message,
                danger_message,
                updatePost
            }
        }
    }
</script>