<template>
  <div>
    <NuxtRouteAnnouncer />
    <NuxtPage v-if="!isCheckingAuth" />
    <loader v-else />
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'

const isCheckingAuth = ref(true)

onMounted(() => {
  const currentPath = window.location.pathname

  if (currentPath === '/login' || currentPath === '/dashboard') {
    const authToken = localStorage.getItem('auth_token')

    if (authToken && currentPath === '/login') {
      window.location.href = '/dashboard'
      return
    }

    if (!authToken && currentPath === '/dashboard') {
      window.location.href = '/login'
      return
    }
  }

  isCheckingAuth.value = false
})
</script>


<style lang="scss">
@use 'styles';
</style>
