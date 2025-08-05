<template>
  <Card class="login-card">
    <template #title>
      <h2 class="login-card-title">Login</h2>
    </template>
    <template #content>
      <div class="login-card-content" @keyup.enter="handleLogin">
        <FloatLabel for="login" variant="on">
          <InputText 
            v-model="login" 
            :class="{ 'p-invalid': error }"
            @click="clearError"
            @focus="hideTooltip"
            @blur="showTooltip"
            v-tooltip.right="tooltipText"
          />
          <label for="login">Login <span>(name and surname)</span></label>
        </FloatLabel>
        
        <FloatLabel for="password" variant="on">
          <InputText 
            v-model="password" 
            type="password"
            :class="{ 'p-invalid': error }"
            @click="clearError"
            @focus="hideTooltip"
            @blur="showTooltip"
          />
          <label for="password">Password <span>(birth date YYYY-MM-DD)</span></label>
        </FloatLabel>
        
        <Button 
          :label="loading ? 'Logging in...' : 'Login'" 
          class="login-card-button" 
          severity="primary"
          :loading="loading"
          :disabled="loading || !login.trim() || !password.trim()"
          @click="handleLogin"
        />
      </div>
    </template>
  </Card>
</template>

<script setup lang="ts">
import { computed, type Ref, ref } from 'vue'

const login: Ref<string> = ref('')
const password: Ref<string> = ref('')
const loading: Ref<boolean> = ref(false)
const error: Ref<string> = ref('')
const tooltip: Ref<boolean> = ref(true)
const config = useRuntimeConfig()

const tooltipText = computed(() => {
  return tooltip.value ? 'login: JohnSmith \npassword: 2021-01-01' : ''
})

async function handleLogin(): Promise<void> {
  if (!login.value.trim() || !password.value.trim()) return

  loading.value = true
  error.value = ''

  try {
    const response = await apiRequest(config.public.apiUrl + '/login', 'POST', {
      login: login.value.trim(),
      password: password.value.trim(),
    })

    if (response.token) {
      localStorage.setItem('auth_token', response.token)
      window.location.href = '/dashboard'
    }
  } catch (error) {
    setTimeout(() => {
      error.value = error.data?.error || 'Login failed. Please try again.'
    }, 500)
  } finally {
    setTimeout(() => {
      loading.value = false
    }, 500)
  }
}

function clearError(): void {
  error.value = ''
}

function hideTooltip(): void {
  tooltip.value = false
}

function showTooltip(): void {
  tooltip.value = true
}
</script>
