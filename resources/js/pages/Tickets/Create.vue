<script setup lang="ts">
import type { TicketPriority } from '@/types'
import { Head, useForm } from '@inertiajs/vue3'
import {
  CircleX,
  Loader2,
  Send,
  Ticket,
} from 'lucide-vue-next'
import InputError from '@/components/InputError.vue'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'
import TicketsLayout from '@/layouts/TicketsLayout.vue'

defineProps<{
  ticketPriorities: TicketPriority[]
}>()

const form = useForm({
  subject: '',
  description: '',
  priority: '',
})

function submit() {
  form.post(route('tickets.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <TicketsLayout>
    <Head title="Create Ticket" />

    <div class="container mx-auto px-4 py-8 max-w-2xl">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-2 mb-4">
          <Ticket class="h-8 w-8 text-primary" />
          <h1 class="text-3xl font-bold">
            Support Ticket
          </h1>
        </div>
        <p class="text-muted-foreground">
          Submit a new support ticket and we'll get back to you as soon as possible.
        </p>
      </div>

      <!-- Ticket Form -->
      <div class="bg-card border border-border rounded-lg shadow-sm p-6">
        <form class="space-y-6" @submit.prevent="submit">
          <!-- Subject Field -->
          <div class="space-y-2">
            <Label for="subject">Subject</Label>
            <Input
              id="subject"
              v-model="form.subject"
              type="text"
              class="h-10 rounded-md focus:border-none focus-visible:outline-none focus-visible:ring-2
                focus-visible:ring-ring focus-visible:ring-offset-2"
              required
              autofocus
              :tabindex="1"
              placeholder="Brief description of your issue"
            />
            <InputError :message="form.errors.subject" />
          </div>

          <!-- Priority Dropdown -->
          <div class="space-y-2">
            <Label for="priority">Priority</Label>
            <Select v-model="form.priority" class="w-full">
              <SelectTrigger class="h-20" :tabindex="2">
                <SelectValue placeholder="Select priority" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectLabel>Priority</SelectLabel>
                  <SelectItem
                    v-for="priority in ticketPriorities"
                    :key="priority.name"
                    :value="priority.name"
                  >
                    {{ priority.name }}
                  </SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>
            <InputError :message="form.errors.priority" />
          </div>

          <!-- Description Field -->
          <div class="space-y-2">
            <Label for="description">Description</Label>
            <Textarea
              id="description"
              v-model="form.description"
              type="text"
              class="h-10 rounded-md focus:border-none focus-visible:outline-none focus-visible:ring-2
                focus-visible:ring-ring focus-visible:ring-offset-2
                min-h-[200px] resize-y field-sizing-fixed"
              required
              :tabindex="3"
              placeholder="Please provide detailed information about your issue..."
            />
            <InputError :message="form.errors.description" />
          </div>

          <!-- Submit Button -->
          <div class="flex gap-3 pt-4">
            <button
              type="submit"
              :disabled="form.processing"
              class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium
                ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2
                focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50
                bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 flex-1"
            >
              <Send v-if="!form.processing" class="h-4 w-4" />
              <Loader2 v-else class="h-4 w-4 animate-spin" />
              {{ form.processing ? 'Submitting...' : 'Submit Ticket' }}
            </button>

            <button
              type="button"
              class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium
                ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2
                focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50
                border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2"
            >
              <CircleX class="h-4 w-4" />
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </TicketsLayout>
</template>
