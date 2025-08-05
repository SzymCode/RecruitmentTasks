<template>
  <div>
    <NuxtRouteAnnouncer />
    <NuxtPage v-if="!isCheckingAuth" />
    <loader v-else />
  </div>
</template>

<script setup lang="ts">
const isCheckingAuth = ref(true)
const route = useRoute()
const protectedRoutes = ref(['/dashboard', '/profile', '/settings'])
const currentPath = route.path

onMounted(() => {
  if (currentPath === '/login' || protectedRoutes.value.includes(currentPath)) {
    const authToken = localStorage.getItem('auth_token')

    if (authToken && currentPath === '/login') {
      window.location.href = '/dashboard'
      return
    }

    if (!authToken && protectedRoutes.value.includes(currentPath)) {
      window.location.href = '/login'
      return
    }
  }

  isCheckingAuth.value = false
})

watch(
  () => route.path,
  (newPath) => {
    if (
      newPath &&
      protectedRoutes.value.includes(newPath) &&
      import.meta.client
    ) {
      const authToken = localStorage.getItem('auth_token')

      if (!authToken) {
        window.location.href = '/login'
      }
    }
  },
  { immediate: true }
)
</script>


<style lang="scss">
@use 'styles';
</style>
