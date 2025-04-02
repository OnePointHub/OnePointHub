<script setup lang="ts">
import { Label } from '@/components/ui/label'

defineProps<{
  label: string
  assign?: string
  required?: boolean
}>()
</script>

<template>
  <Label :for="assign" class="block text-foreground mb-1">
    {{ label }} <span v-if="required === true" class="text-red-500">*</span>
  </Label>
</template>
