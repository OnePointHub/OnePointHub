<script setup lang="ts">
import AppLogo from '@/components/Main/AppLogo.vue'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Link } from '@inertiajs/vue3'
import { BookOpenIcon } from 'lucide-vue-next'

defineProps<{
  title?: string
  description?: string
}>()
</script>

<template>
  <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-purple-50/50 dark:bg-gray-950 p-6 md:p-10">
    <div class="flex w-full max-w-md flex-col gap-6">
      <Link :href="route('home')" class="flex items-center justify-center gap-2 font-medium">
        <div class="flex h-9 w-9 items-center justify-center">
          <div class="flex items-center justify-center">
            <div class="flex items-center gap-2">
              <BookOpenIcon class="h-8 w-8 dark:text-white" />
              <span class="text-xl font-bold dark:text-white">
                OnePointHub
              </span>
            </div>
          </div>
        </div>
      </Link>

      <div class="flex flex-col gap-6">
        <Card class="rounded-xl">
          <CardHeader class="px-10 pb-0 pt-8 text-center">
            <CardTitle class="text-xl">
              {{ title }}
            </CardTitle>
            <CardDescription>
              {{ description }}
            </CardDescription>
          </CardHeader>
          <CardContent class="px-10 py-8">
            <slot />
          </CardContent>
        </Card>
      </div>
    </div>
  </div>
</template>
