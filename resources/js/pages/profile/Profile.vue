<script setup lang="ts">
import type { SharedData, User } from '@/types'
import Input from '@/components/Main/Form/Input.vue'
import InputError from '@/components/Main/Form/InputError.vue'
import MainLayout from '@/layouts/MainLayout.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import {
  CameraIcon,
  CircleDotIcon,
  KeyIcon,
  LayoutDashboardIcon,
  PencilIcon,
  SaveIcon,
  ShieldIcon,
  TrashIcon,
  UploadIcon,
  XIcon,
} from 'lucide-vue-next'
import { ref } from 'vue'

interface Props {
  mustVerifyEmail: boolean
  status?: string
}

defineProps<Props>()

// State
const activeTab = ref('overview')
const editPersonalInfo = ref(false)
const changePassword = ref(false)
const showAvatarModal = ref(false)

const page = usePage<SharedData>()
const user = page.props.auth.user as User

const form = useForm({
  name: user.name,
  email: user.email,
  phone: user.phone,
  location: user.location,
})

const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

function submit() {
  form.patch(route('profile.update'), {
    preserveScroll: true,
    onSuccess: () => editPersonalInfo.value = false,
  })
}

function updatePassword() {
  passwordForm.put(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      passwordForm.reset()
      changePassword.value = false
    },
    onError: (errors: any) => {
      if (errors.password) {
        passwordForm.reset('password', 'password_confirmation')
      }

      if (errors.current_password) {
        passwordForm.reset('current_password')
      }
    },
  })
}
</script>

<template>
  <MainLayout>
    <Head title="Profile" />

    <div class="mb-8">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
          <div class="relative">
            <img
              src="https://ui-avatars.com/api/?name=John+Doe&background=6d28d9&color=fff&size=128"
              alt="John Doe"
              class="h-24 w-24 rounded-full ring-4 ring-purple-500"
            >
            <button
              class="absolute bottom-0 right-0 rounded-full bg-purple-600 p-1.5 text-white hover:bg-purple-700"
              @click="showAvatarModal = true"
            >
              <CameraIcon class="h-4 w-4" />
            </button>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-purple-900 dark:text-purple-300">
              John Doe
            </h1>
            <p class="text-muted-foreground">
              john.doe@example.com
            </p>
            <div class="mt-1 flex items-center gap-2">
              <span class="inline-flex items-center rounded-full bg-green-100 dark:bg-green-900/30 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:text-green-300">
                <CircleDotIcon class="mr-1 h-2 w-2 text-green-500" />
                Active
              </span>
              <span class="inline-flex items-center rounded-full bg-purple-100 dark:bg-purple-900/30 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:text-purple-300">
                Admin
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mb-6 border-b border-purple-200 dark:border-purple-800">
      <div class="flex overflow-x-auto">
        <button
          class="inline-flex min-w-max items-center gap-2 px-4 py-2 text-sm font-medium border-b-2 -mb-px"
          :class="activeTab === 'overview' ? 'text-purple-600 dark:text-purple-400 border-purple-600 dark:border-purple-400' : 'text-muted-foreground border-transparent hover:text-foreground hover:border-purple-200 dark:hover:border-purple-800'"
          @click="activeTab = 'overview'"
        >
          <LayoutDashboardIcon class="h-4 w-4" />
          <span>Overview</span>
        </button>
        <button
          class="inline-flex min-w-max items-center gap-2 px-4 py-2 text-sm font-medium border-b-2 -mb-px"
          :class="activeTab === 'security' ? 'text-purple-600 dark:text-purple-400 border-purple-600 dark:border-purple-400' : 'text-muted-foreground border-transparent hover:text-foreground hover:border-purple-200 dark:hover:border-purple-800'"
          @click="activeTab = 'security'"
        >
          <ShieldIcon class="h-4 w-4" />
          <span>Security</span>
        </button>
      </div>
    </div>

    <!-- Overview Tab -->
    <div v-if="activeTab === 'overview'" class="space-y-6">
      <!-- Personal Information -->
      <div class="rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 overflow-hidden">
        <div class="flex items-center justify-between border-b border-purple-200 dark:border-purple-800 bg-purple-50 dark:bg-purple-900/10 px-4 py-3">
          <h2 class="text-lg font-medium text-purple-900 dark:text-purple-300">
            Personal Information
          </h2>
          <button
            class="rounded-md p-1.5 text-purple-600 dark:text-purple-400 hover:bg-purple-100 dark:hover:bg-purple-900/50"
            @click="editPersonalInfo = true"
          >
            <PencilIcon class="h-4 w-4" />
          </button>
        </div>

        <div v-if="!editPersonalInfo" class="p-4">
          <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-muted-foreground">
                Full Name
              </dt>
              <dd class="mt-1 text-sm text-foreground">
                {{ form.name }}
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-muted-foreground">
                Email
              </dt>
              <dd class="mt-1 text-sm text-foreground">
                {{ form.email }}
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-muted-foreground">
                Phone
              </dt>
              <dd class="mt-1 text-sm text-foreground">
                {{ form.phone }}
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-muted-foreground">
                Location
              </dt>
              <dd class="mt-1 text-sm text-foreground">
                {{ form.location }}
              </dd>
            </div>
          </dl>
        </div>
        <div v-else class="p-4">
          <form class="space-y-4" @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <div>
                <label for="name" class="block text-sm font-medium text-foreground">
                  Full Name
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  required
                  autocomplete="name"
                  class="mt-1 w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                >
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-foreground">
                  Email
                </label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  autocomplete="email"
                  class="mt-1 w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                >
              </div>
              <div>
                <label for="phone" class="block text-sm font-medium text-foreground">
                  Phone
                </label>
                <input
                  id="phone"
                  v-model="form.phone"
                  type="text"
                  class="mt-1 w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                >
              </div>
              <div>
                <label for="location" class="block text-sm font-medium text-foreground">
                  Location
                </label>
                <input
                  id="location"
                  v-model="form.location"
                  type="text"
                  class="mt-1 w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                >
              </div>
            </div>

            <div class="flex justify-end gap-3">
              <button
                type="button"
                class="inline-flex items-center gap-2 rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-foreground hover:bg-purple-50 dark:hover:bg-purple-900/20"
                @click="editPersonalInfo = false"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-4 py-2 text-sm font-medium text-white"
              >
                <SaveIcon class="h-4 w-4" />
                <span>Save Changes</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Security Tab -->
    <div v-if="activeTab === 'security'" class="space-y-6">
      <!-- Password -->
      <div class="rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 overflow-hidden">
        <div class="flex items-center justify-between border-b border-purple-200 dark:border-purple-800 bg-purple-50 dark:bg-purple-900/10 px-4 py-3">
          <h2 class="text-lg font-medium text-purple-900 dark:text-purple-300">
            Password
          </h2>
          <button
            class="rounded-md p-1.5 text-purple-600 dark:text-purple-400 hover:bg-purple-100 dark:hover:bg-purple-900/50"
            @click="changePassword = true"
          >
            <PencilIcon class="h-4 w-4" />
          </button>
        </div>

        <div v-if="!changePassword" class="p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-foreground">
                Password last changed on 2023-02-15T09:30:00Z
              </p>
              <p class="mt-1 text-xs text-muted-foreground">
                We recommend changing your password every 90 days for security reasons.
              </p>
            </div>
            <button
              class="inline-flex items-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-4 py-2 text-sm font-medium text-white"
              @click="changePassword = true"
            >
              <KeyIcon class="h-4 w-4" />
              <span>Change Password</span>
            </button>
          </div>
        </div>

        <div v-else class="p-4">
          <form class="space-y-4" @submit.prevent="updatePassword">
            <div>
              <label for="current-password" class="block text-sm font-medium text-foreground">
                Current Password
              </label>
              <Input
                id="current-password"
                v-model="passwordForm.current_password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="Current password"
              />
              <InputError :message="passwordForm.errors.current_password" />
            </div>
            <div>
              <label for="password" class="block text-sm font-medium text-foreground">
                New Password
              </label>
              <input
                id="password"
                v-model="passwordForm.password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="New password"
                class="mt-1 w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
              >
              <InputError :message="passwordForm.errors.password" />
            </div>
            <div>
              <label for="confirm-password" class="block text-sm font-medium text-foreground">
                Confirm New Password
              </label>
              <input
                id="confirm-password"
                v-model="passwordForm.password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Confirm password"
                class="mt-1 w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
              >
              <InputError :message="passwordForm.errors.password_confirmation" />
            </div>

            <div class="flex justify-end gap-3">
              <button
                type="button"
                class="inline-flex items-center gap-2 rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-foreground hover:bg-purple-50 dark:hover:bg-purple-900/20"
                @click="changePassword = false"
              >
                Cancel
              </button>
              <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-4 py-2 text-sm font-medium text-white"
              >
                <SaveIcon class="h-4 w-4" />
                <span>Update Password</span>
              </button>
              <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
              >
                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">
                  Saved.
                </p>
              </Transition>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div v-if="showAvatarModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
      <div class="w-full max-w-md rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-semibold text-foreground">
            Update Profile Picture
          </h2>
          <button
            class="rounded-md p-1.5 text-muted-foreground hover:bg-purple-100 dark:hover:bg-purple-900/50"
            @click="showAvatarModal = false"
          >
            <XIcon class="h-4 w-4" />
          </button>
        </div>

        <div class="space-y-4">
          <div class="flex flex-col items-center justify-center">
            <img
              src="https://ui-avatars.com/api/?name=John+Doe&background=6d28d9&color=fff&size=128"
              alt="John Doe"
              class="h-32 w-32 rounded-full"
            >

            <div class="mt-4 flex items-center gap-4">
              <button
                class="inline-flex items-center gap-2 rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-foreground hover:bg-purple-50 dark:hover:bg-purple-900/20"
              >
                <UploadIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
                <span>Upload Image</span>
              </button>
              <button
                class="inline-flex items-center gap-2 rounded-md border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/10 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/20"
              >
                <TrashIcon class="h-4 w-4" />
                <span>Remove</span>
              </button>
            </div>
          </div>

          <div class="border-t border-purple-200 dark:border-purple-800 pt-4">
            <p class="text-sm text-muted-foreground mb-2">
              Or choose from avatars
            </p>
            <div class="grid grid-cols-4 gap-2">
              <button
                v-for="i in 8"
                :key="i"
                class="rounded-md p-1 hover:bg-purple-100 dark:hover:bg-purple-900/50"
              >
                <img
                  :src="`https://ui-avatars.com/api/?name=${String.fromCharCode(64 + i)}&background=6d28d9&color=fff&size=64`"
                  :alt="`Avatar ${i}`"
                  class="h-12 w-12 rounded-full"
                >
              </button>
            </div>
          </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
          <button
            class="inline-flex items-center gap-2 rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-foreground hover:bg-purple-50 dark:hover:bg-purple-900/20"
            @click="showAvatarModal = false"
          >
            Cancel
          </button>
          <button
            class="inline-flex items-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-4 py-2 text-sm font-medium text-white"
          >
            <SaveIcon class="h-4 w-4" />
            <span>Save Changes</span>
          </button>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
