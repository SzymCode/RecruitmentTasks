<template>
  <div class="navbar">
    <div class="navbar-container container">
        <NuxtLink to="/">
          <img src="/alab-laboratoria.svg" alt="logo" class="navbar-container-logo" />
        </NuxtLink>
        <div class="navbar-container-links">
          <Button 
            v-for="link in links" 
            :key="link.name"
            text 
            rounded 
            class="navbar-container-links-button"
            :class="{ 'p-button-active': $route.path === link.to }"
            @click="navigateTo(link.to)"
          >
            <Icon 
              :name="link.icon" 
              :style="{ color: $route.path === link.to ? 'var(--p-primary-500)' : 'var(--p-neutral-800)' }" 
            />
          </Button>   
        </div>
        <logout class="navbar-container-logout" />
    </div>
  </div>
</template>

<script setup lang="ts">
const links = [
  {
    name: 'Dashboard',
    icon: 'prime:list-check',
    to: '/dashboard',
  },
  {
    name: 'Profile',
    icon: 'prime:user',
    to: '/profile',
  },
  {
    name: 'Settings',
    icon: 'prime:cog',
    to: '/settings',
  },
]
</script>