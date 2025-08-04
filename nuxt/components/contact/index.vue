<template>
  <div class="contact">
    <div class="contact-container container">
      <h2 class="contact-container-title">
        Contact Me
      </h2>
      <p class="contact-container-description">
        If you found this task interesting, you can contact me via email or LinkedIn.
      </p>

      <div class="contact-container-links"> 
        <a v-for="link in links" :key="link.name" :href="link.href" target="_blank">
          <Icon :name="link.icon" />
        </a>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import links from './social_links'
</script>