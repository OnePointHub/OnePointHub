<script setup lang="ts">
import Input from '@/components/Main/Form/Input.vue'
import InputError from '@/components/Main/Form/InputError.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { LoaderIcon } from 'lucide-vue-next'

defineProps<{
  status?: string
}>()

const form = useForm({
  email: '',
})

function submit() {
  form.post(route('password.email'))
}
</script>

<template>
  <AuthLayout>
    <Head title="Forgot password" />

    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <div class="space-y-6">
      <form @submit.prevent="submit">
        <div class="grid gap-2">
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Email
          </label>
          <Input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
            :tabindex="1"
            autocomplete="email"
            placeholder="your.email@example.com"
            :error="form.errors.email"
          />
          <InputError :message="form.errors.email" />
        </div>

        <div class="my-6 flex items-center justify-start">
          <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm
              font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2
              focus:ring-offset-2 focus:ring-purple-500"
            :disabled="form.processing"
          >
            <LoaderIcon v-if="form.processing" class="animate-spin h-5 w-5 mr-2" />
            {{ form.processing ? 'Sending email...' : 'Email password reset link' }}
          </button>
        </div>
      </form>

      <div class="space-x-1 text-center text-sm text-muted-foreground">
        <span>Or, return to</span>
        <Link :href="route('login')">
          log in
        </Link>
      </div>
    </div>
  </AuthLayout>
</template>
