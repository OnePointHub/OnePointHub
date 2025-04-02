<script setup lang="ts">
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AuthBase from '@/layouts/AuthLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { LoaderCircle } from 'lucide-vue-next'

defineProps<{
  status?: string
  canResetPassword: boolean
}>()

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post(route('invite.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <AuthBase title="Invite member to join" description="Enter member's email to send invitation">
    <Head title="Log in" />

    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <form class="flex flex-col gap-6" @submit.prevent="submit">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="email">Email address</Label>
          <Input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
            :tabindex="1"
            autocomplete="email"
            placeholder="email@example.com"
          />
          <InputError :message="form.errors.email" />
        </div>
        <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
          Invite
        </Button>
      </div>
    </form>
  </AuthBase>
</template>
