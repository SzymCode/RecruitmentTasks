<template>
  <div class="profile">
    <div class="profile-container container">
      <Card class="profile-card">
        <template #content>
          <div v-if="loading" class="profile-content-loading">
            <p>Loading profile...</p>
          </div>
                    
          <div v-else-if="patient" class="profile-content">
            <h2 class="profile-content-title">{{ patient.name }} {{ patient.surname }}</h2>
            <p class="profile-content-details">
              <strong>Patient ID:</strong> {{ patient.id }}<br>
              <strong>Sex:</strong> {{ patient.sex }}<br>
              <strong>Birth Date:</strong> {{ patient.birthDate }}
            </p>
          </div>
                    
          <div v-else class="profile-content-error">
            <p>Failed to load profile data.</p>
            <Button label="Retry" @click="fetchPatientData" />
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()
const patient = ref(null)
const loading = ref(true)

onMounted(async () => {
  await fetchPatientData()
})

async function fetchPatientData() {
  try {
    loading.value = true
    const token = localStorage.getItem('auth_token')

    if (!token) {
      console.error('No authentication token found')
      return
    }

    const response = await $fetch(config.public.apiUrl + '/me', {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })

    patient.value = response
    localStorage.setItem('patient_data', JSON.stringify(response))
  } catch (error) {
    if (error.status === 401) {
      localStorage.removeItem('auth_token')
      localStorage.removeItem('patient_data')
      window.location.href = '/login'
    }
  } finally {
    loading.value = false
  }
}
</script>

