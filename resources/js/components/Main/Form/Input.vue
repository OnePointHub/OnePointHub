<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { useVModel } from '@vueuse/core'

const props = defineProps<{
  defaultValue?: string | number
  modelValue?: string | number
  class?: HTMLAttributes['class']
  error?: string
}>()

const emits = defineEmits<{
  (e: 'update:modelValue', payload: string | number): void
}>()

const modelValue = useVModel(props, 'modelValue', emits, {
  passive: true,
  defaultValue: props.defaultValue,
})
</script>

<template>
  <input
    v-model="modelValue"
    class="w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900
      py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500
      focus:border-purple-500"
    :class="{ 'border-red-500 dark:border-red-500': error }"
  >
</template>
