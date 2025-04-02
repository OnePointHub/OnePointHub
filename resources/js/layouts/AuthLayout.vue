<script setup lang="ts">
import {
  BookOpenIcon,
  MoonIcon,
  SunIcon,
} from 'lucide-vue-next'
import { onMounted, ref } from 'vue'

const isDark = ref(false)

// Toggle theme
function toggleTheme() {
  isDark.value = !isDark.value

  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  }
  else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

onMounted(() => {
  // Check if dark mode is enabled
  const savedTheme = localStorage.getItem('theme')
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches

  if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
    isDark.value = true
    document.documentElement.classList.add('dark')
  }
  else {
    isDark.value = false
    document.documentElement.classList.remove('dark')
  }
})
</script>

<template>
  <div class="min-h-screen flex flex-col bg-purple-50 dark:bg-gray-950">
    <!-- Header with logo -->
    <header class="w-full py-6 px-4 flex justify-center">
      <div class="flex items-center gap-2">
        <BookOpenIcon class="h-8 w-8 text-purple-600 dark:text-purple-400" />
        <span class="text-2xl font-bold text-purple-900 dark:text-purple-300">OnePointHub</span>
      </div>
    </header>

    <!-- Main content -->
    <main class="flex-1 flex items-center justify-center px-4 py-8">
      <div class="w-full max-w-md">
        <slot />
      </div>
    </main>
    <!-- Footer -->
    <footer class="py-6 px-4 text-center text-sm text-gray-500 dark:text-gray-400">
      <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <div class="flex items-center gap-4">
          <a href="#" class="hover:text-purple-600 dark:hover:text-purple-400">Privacy Policy</a>
          <span class="hidden sm:inline">•</span>
          <a href="#" class="hover:text-purple-600 dark:hover:text-purple-400">Terms of Service</a>
        </div>
        <span class="hidden sm:inline">•</span>
        <div class="flex items-center gap-2">
          <span>© {{ new Date().getFullYear() }} OnePointHub</span>
          <button
            class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-800"
            aria-label="Toggle theme"
            @click="toggleTheme"
          >
            <SunIcon v-if="isDark" class="h-4 w-4" />
            <MoonIcon v-else class="h-4 w-4" />
          </button>
        </div>
      </div>
    </footer>
  </div>
</template>
