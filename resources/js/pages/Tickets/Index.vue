<script setup>
import { HelpCircle, Loader2 } from 'lucide-vue-next'
import { ref } from 'vue'
import { Button } from '@/components/ui/button'
import { FormField } from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { Select } from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'

const form = ref({
  name: '',
  email: '',
  subject: '',
  category: '',
  message: '',
  attachment: null,
})

const loading = ref(false)

const handleFile = (event) => {
  form.value.attachment = event.target.files[0]
}

const submitForm = async () => {
  loading.value = true

  const formData = new FormData()
  for (const key in form.value) {
    if (form.value[key]) {
      formData.append(key, form.value[key])
    }
  }

  try {
    // Replace with your API endpoint
    await fetch('/api/tickets', {
      method: 'POST',
      body: formData,
    })
    alert('Ticket submitted successfully!')
    form.value = {
      name: '',
      email: '',
      subject: '',
      category: '',
      message: '',
      attachment: null,
    }
  } catch (error) {
    alert('There was an error submitting your ticket.')
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="max-w-2xl mx-auto p-6 bg-background text-foreground rounded-2xl shadow-md border border-border">
    <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2">
      <HelpCircle class="w-6 h-6" />
      Submit a Ticket
    </h2>
    <form @submit.prevent="submitForm" class="space-y-4">
      <FormField label="Subject">
        <Input v-model="form.subject" required />
      </FormField>

      <FormField label="Category">
        <Select v-model="form.category">
          <option disabled value="">Select a category</option>
          <option value="support">Support</option>
          <option value="billing">Billing</option>
          <option value="technical">Technical</option>
        </Select>
      </FormField>

      <FormField label="Message">
        <Textarea v-model="form.message" rows="5" required />
      </FormField>

      <FormField label="Attachment (optional)">
        <Input type="file" @change="handleFile" />
      </FormField>

      <Button type="submit" class="w-full" :disabled="loading">
        <Loader2 v-if="loading" class="animate-spin mr-2 h-4 w-4" />
        Submit Ticket
      </Button>
    </form>
  </div>
</template>

