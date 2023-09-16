<template>
    <div>
        <h5>
            Showing {{ results.from }} to {{ results.to }} of {{ results.total }} | Page {{ results.current_page }} of {{ results.last_page }}
        </h5>
    </div>
</template>


<script>
    export default {
        props: ['results']
    }
</script>
