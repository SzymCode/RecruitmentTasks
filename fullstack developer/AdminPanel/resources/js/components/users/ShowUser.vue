<template>
    <div class="modal fade" id="showUserModal" tabindex="-1" role="dialog" aria-labelledby="showUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h3 class="modal-title" id="showUserModalLabel">User Details</h3>
                </div>


                <!-- User details -->
                <div class="modal-body">
                    <div class="modalDetails">
                        <label>
                            <b>Name:</b> 
                            {{ data.name }}
                        </label>
                    </div>
                    <div class="modalDetails">
                        <label>
                            <b>Email: </b> 
                            {{ data.email }}
                        </label>
                    </div>
                    <div class="modalDetails">
                        <label>
                            <b>Role:</b> 
                            {{ data.role }}
                        </label>
                    </div>
                    <div class="modalDetails">
                        <label>
                            <b>Settings:</b> 
                            {{ data.settings === '' ? '' : 'This user have no settings' }}
                        </label>
                    </div>
                    <div class="modalDetails">
                        <label>
                            <b>User Since: </b>
                            {{ data.created_at }}
                        </label>
                    </div>
                    <div class="modalDetails">
                        <label>
                            <b>Updated At: </b>
                            {{ data.updated_at }}
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
        props: ['user'],
        setup(props) {
            const { user } = toRefs(props)

            const data = ref({})

            function assignPropsToData() {
                Object.assign(data.value, user.value)
            }

            watch(user, () => {
                assignPropsToData()
            }), { deep: true }

            return {
                data,
            }
        }
    }
</script>