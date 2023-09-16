<template>
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="postModalLabel">Create new post!</h3>
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

                        <div class="modal-footer">
                            <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" @click.prevent="this.storePost">Save changes</button>
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
                title: '',
                description: '',
                created_at: '',
            }
            const errors = []

            function storePost() {
                axios.post('/data/posts', {
                    title: this.data.title,
                    description: this.data.description,
                    created_at: this.data.created_at,
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
                storePost,
                flashErrors
            }
        }
    }
</script>


<style scoped>
    @import '../../../css/app.css';
</style>
