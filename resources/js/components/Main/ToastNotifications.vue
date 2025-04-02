<script setup lang="ts">
import { useToasts } from '@/composables/useToastNotifications'

const { toasts, toastAgain, reToasted } = useToasts()
</script>

<template>
  <div>
    <button
      v-if="toasts"
      class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 hover:bg-gray-800
        hover:text-white dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
      :class="{ 'animate-pulse': !reToasted }"
      @click="toastAgain()"
    >
      <component :is="reToasted ? 'BellOff' : 'BellRing'" class="h-5 w-5" />
    </button>
  </div>
</template>
