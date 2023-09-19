<template>
    <div class="modal fade" id="showPostModal" tabindex="-1" role="dialog" aria-labelledby="showPostModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h3 class="modal-title" id="showPostModalLabel">Post Details</h3>
                </div>


                <!-- User details -->
                <div class="modal-body">
                    <div class="modalDetails">
                        <label>
                            <b>Title: </b>
                            {{ data.title }}
                        </label>
                    </div>
                    <div class="modalDetails">
                        <label>
                            <b>Description: </b>
                            {{ data.description }}
                        </label>
                    </div>
                    <div class="modalDetails">
                        <label>
                            <b>Post Date: </b>
                            {{ data.created_at }}
                        </label>
                    </div>
                    <div class="modalDetails">
                        <label>
                            <b>Tags: </b> 
                            <div v-if="data.tags && data.tags.length > 0" class="tagsDetailsModal">
                                <div v-for="tag in data.tags.split(', ')" :key="tag" class="tagDetailsModal">
                                    {{ tag }}
                                </div>
                            </div> 
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="modal-footer">
                        <button class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
    import { ref, toRefs, watch } from 'vue'

    export default {
        props: ['post'],
        setup(props) {
            const { post } = toRefs(props)

            const data = ref({})

            function assignPropsToData() {
                Object.assign(data.value, post.value)
            }

            watch(post, () => {
                assignPropsToData()
            }), { deep: true }

            return {
                data,
            }
        }
    }
</script>