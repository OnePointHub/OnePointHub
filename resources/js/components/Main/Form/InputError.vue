<script setup lang="ts">
defineProps<{
  message?: string
}>()
</script>

<template>
  <div v-show="message">
    <p class="mt-1 text-xs text-red-500">
      {{ message }}
    </p>
  </div>
</template>
