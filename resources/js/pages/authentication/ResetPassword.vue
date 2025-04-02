<script setup lang="ts">
import Input from '@/components/Main/Form/Input.vue'
import InputError from '@/components/Main/Form/InputError.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { LoaderIcon } from 'lucide-vue-next'

interface Props {
  token: string
  email: string
}

const props = defineProps<Props>()

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

function submit() {
  form.post(route('password.store'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation')
    },
  })
}
</script>

<template>
  <AuthLayout>
    <Head title="Reset password" />

    <form @submit.prevent="submit">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Email
          </label>
          <Input
            id="email"
            v-model="form.email"
            type="email"
            autocomplete="email"
            readonly
            placeholder="your.email@example.com"
            :error="form.errors.email"
          />
          <InputError :message="form.errors.email" />
        </div>

        <div class="grid gap-2">
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Password
          </label>
          <Input
            id="password"
            v-model="form.password"
            type="password"
            required
            autofocus
            :tabindex="1"
            autocomplete="current-password"
            placeholder="••••••••"
            :error="form.errors.password"
          />
          <InputError :message="form.errors.password" />
        </div>

        <div class="grid gap-2">
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Confirm Password
          </label>
          <Input
            id="password"
            v-model="form.password_confirmation"
            type="password"
            required
            :tabindex="2"
            autocomplete="current-password"
            placeholder="••••••••"
            :error="form.errors.password_confirmation"
          />
          <InputError :message="form.errors.password" />
        </div>

        <button
          type="submit"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm
              font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2
              focus:ring-offset-2 focus:ring-purple-500"
          :disabled="form.processing"
        >
          <LoaderIcon v-if="form.processing" class="animate-spin h-5 w-5 mr-2" />
          {{ form.processing ? 'Resetting password...' : 'Reset password' }}
        </button>
      </div>
    </form>
  </AuthLayout>
</template>
