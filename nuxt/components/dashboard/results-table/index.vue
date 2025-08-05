<template>
  <div class="results container">
  <Card class="results-card ">
    <template #title>   
      <h1 class="results-title">Test Results</h1>
    </template>
    <template #content>
      <DataTable 
        :value="results" 
        :rows="10" 
        :paginator="true" 
        :rowsPerPageOptions="[10, 20, 50, 100]" 
        class="results-data-table"
      >
        <Column
          v-for="column in columns"
          :key="column.field"
          :field="column.field"
          :header="column.header"
          sortable
        />
      </DataTable>
    </template>
  </Card>
  </div>
</template>

<script setup lang="ts">
import { OrderInterface, TestResultInterface } from '~/nuxt/types'

const config = useRuntimeConfig()
const results = ref<TestResultInterface[]>([])

const columns = ref([
  { field: 'id', header: 'Test ID' },
  { field: 'orderId', header: 'Order ID' },
  { field: 'name', header: 'Test Name' },
  { field: 'value', header: 'Test Value' },
  { field: 'reference', header: 'Test Reference' },
])

onMounted(() => {
  $fetch(config.public.apiUrl + '/test-results', {
    method: 'GET',
    headers: {
      Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
    },
  })
    .then((response) => {
      const flattenedResults: TestResultInterface[] = []

      response.orders.forEach((order: OrderInterface) => {
        order.results.forEach((result: TestResultInterface) => {
          flattenedResults.push({
            ...result,
            orderId: order.orderId,
            patientId: order.patientId,
          })
        })
      })

      results.value = flattenedResults
      console.log(results.value)
    })
    .catch((error) => {
      console.error('Error fetching test results:', error)
    })
})
</script>   