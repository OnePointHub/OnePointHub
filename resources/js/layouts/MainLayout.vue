<script setup>
import ToastNotifications from '@/components/Main/ToastNotifications.vue'
import { SidebarProvider } from '@/components/ui/sidebar/index.js'
import Header from '@/layouts/main/Header.vue'
import MainSidebar from '@/layouts/main/MainSidebar.vue'
</script>

<template>
  <SidebarProvider>
    <div class="flex h-screen w-full bg-background">
      <!-- Sidebar -->
      <MainSidebar />
      <!-- Main Content -->
      <div class="flex flex-1 flex-col overflow-hidden">
        <!-- Header -->
        <Header />
        <ToastNotifications />
        <!-- Main Content Area -->
        <main class="flex-1 overflow-auto p-4 md:p-6 bg-purple-50/50 dark:bg-gray-950">
          <div class="mx-auto max-w-7xl">
            <slot />
          </div>
        </main>
      </div>
    </div>
  </SidebarProvider>
</template>
