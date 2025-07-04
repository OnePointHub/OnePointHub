<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import { Moon, Sun } from 'lucide-vue-next'
import { onMounted, onUnmounted, ref } from 'vue'
import { toast } from 'vue-sonner'
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'

const isDark = ref(false)

const page = usePage()

const finish = router.on('finish', () => {
  if (page.props.flash.message) {
    toast.success(page.props.flash.message)
  }
})

onUnmounted(() => finish())
function updateTheme() {
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  }
  else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

function toggleTheme() {
  isDark.value = !isDark.value
  updateTheme()
}

onMounted(() => {
  // Initialize theme from localStorage
  const savedTheme = localStorage.getItem('theme')
  if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDark.value = true
  }
  updateTheme()
})
</script>

<template>
  <Toaster position="top-right" :expand="true" rich-colors />

  <div class="min-h-screen bg-background text-foreground transition-colors duration-300">
    <!-- Theme Toggle -->
    <div class="absolute top-4 right-4">
      <button
        class="p-2 rounded-lg bg-card border border-border hover:bg-accent transition-colors"
        :title="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
        @click="toggleTheme"
      >
        <Sun v-if="isDark" class="h-5 w-5" />
        <Moon v-else class="h-5 w-5" />
      </button>
    </div>
    <slot />
  </div>
</template>
