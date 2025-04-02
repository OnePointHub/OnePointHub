<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <MainLayout>
    <Head title="Dashboard" />
    <!-- Page Header with purple accent -->
    <div class="mb-8 border-l-4 border-purple-500 pl-4">
      <h1 class="text-3xl font-bold text-purple-900 dark:text-purple-300">
        Dashboard
      </h1>
      <p class="mt-1 text-muted-foreground">
        Welcome back to OnePointHub.
      </p>
    </div>
  </MainLayout>
</template>
