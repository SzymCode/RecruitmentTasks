<template>
    <div>
        <h5 class="details">
            <div v-if="results.total === 0">
                <p>No results found.</p>
            </div>
            <div v-else-if="results.to < 10 && results.to == results.total">
                <p>Showing {{ results.total }} results.</p>
            </div>
            <div v-else>
                <p>
                    Showing {{ results.from }} to {{ results.to }} of {{ results.total }} results.
                </p>
            </div>
        </h5>
    </div>
</template>


<script>
    export default {
        props: ['results']
    }
</script>