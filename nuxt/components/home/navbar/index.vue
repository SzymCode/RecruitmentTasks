<template>
  <nav class="home-navbar">
    <div class="home-navbar-container container">
      <a href="/" class="home-navbar-header">
        <h1>PatientManager</h1>
      </a>
      <Button 
        :style="{ padding: '.5em 1.5em' }" 
        class="home-navbar-login-button" 
        severity="primary" 
        rounded 
        @click="navigateToLogin"
      >
        Login
      </Button>
    </div>
  </nav>
</template>

<script setup lang="ts">
function navigateToLogin() {
  window.location.href = '/login'
}
</script>