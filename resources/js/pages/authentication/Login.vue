<script setup lang="ts">
import Input from '@/components/Main/Form/Input.vue'
import InputError from '@/components/Main/Form/InputError.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { EyeIcon, EyeOffIcon, LoaderIcon } from 'lucide-vue-next'
import { ref } from 'vue'

defineProps<{
  status?: string
  canResetPassword: boolean
}>()

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const showPassword = ref(false)

function submit() {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <AuthLayout>
    <Head title="Log in" />
    <!-- Login card -->
    <div
      class="bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-purple-100 dark:border-purple-900
            overflow-hidden"
    >
      <!-- Card header with gradient -->
      <div class="bg-gradient-to-r from-purple-600 to-purple-500 px-6 py-4">
        <h1 class="text-xl font-bold text-white">
          Welcome back
        </h1>
        <p class="text-purple-100 text-sm">
          Sign in to your NexaDocs account
        </p>
      </div>

      <!-- Login form -->
      <div class="p-6">
        <form class="space-y-4" @submit.prevent="submit">
          <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
          </div>

          <!-- Email field -->
          <div>
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

          <!-- Password field -->
          <div>
            <div class="flex items-center justify-between mb-1">
              <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Password
              </label>
              <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="text-xs text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300"
              >
                Forgot password?
              </Link>
            </div>
            <div class="relative">
              <Input
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                required
                :tabindex="2"
                autocomplete="current-password"
                placeholder="••••••••"
                :error="form.errors.password"
              />
              <InputError :message="form.errors.password" />
              <button
                type="button"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600
                  dark:hover:text-gray-300"
                @click="showPassword = !showPassword"
              >
                <EyeIcon v-if="showPassword" class="h-5 w-5" />
                <EyeOffIcon v-else class="h-5 w-5" />
              </button>
            </div>
          </div>

          <!-- Remember me checkbox -->
          <div class="flex items-center">
            <input
              id="remember-me"
              v-model="form.remember"
              type="checkbox"
              class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
            >
            <label for="remember-me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
              Remember me
            </label>
          </div>

          <!-- Login button -->
          <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm
              font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2
              focus:ring-offset-2 focus:ring-purple-500"
            :disabled="form.processing"
          >
            <LoaderIcon v-if="form.processing" class="animate-spin h-5 w-5 mr-2" />
            {{ form.processing ? 'Signing in...' : 'Sign in' }}
          </button>
        </form>
      </div>
    </div>
  </AuthLayout>
</template>
