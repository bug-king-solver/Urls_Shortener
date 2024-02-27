<template>
  <ShortenForm v-model:redirect-url="redirectUrl" />
  <ShortenedLink :redirect-url="redirectUrl" />
</template>

<script setup lang="ts">
  import { ref } from 'vue';

  import ShortenForm from './ShortenForm.vue';
  import ShortenedLink from './ShortenedLink.vue';

  const redirectUrl = ref("");
</script>
  