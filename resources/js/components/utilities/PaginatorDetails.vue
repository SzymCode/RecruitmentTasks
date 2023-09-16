<template>
    <div>
        <h5 class="details">
            Showing {{ results.from }} to {{ results.to }} of {{ results.total }}
        </h5>
    </div>
</template>


<script>
    export default {
        props: ['results']
    }
</script>


<style scoped>
    @import '../../../css/app.css';
</style>
