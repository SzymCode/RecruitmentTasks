<template>
  <Button class="logout-button" text rounded>
    <Icon name="prime:sign-out" @click="handleLogout"/>
  </Button>
</template>

<script setup lang="ts">
const config = useRuntimeConfig()

const handleLogout = async () => {
  try {
    await apiRequest(config.public.apiUrl + '/logout', 'POST')
    localStorage.removeItem('auth_token')
    window.location.href = '/login'
  } catch (error) {
    localStorage.removeItem('auth_token')
    window.location.href = '/login'
  }
}
</script>