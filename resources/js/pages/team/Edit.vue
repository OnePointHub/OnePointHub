<script setup lang="ts">
import type { SharedData, User } from '@/types'
import Input from '@/components/Main/Form/Input.vue'
import InputError from '@/components/Main/Form/InputError.vue'
import Label from '@/components/Main/Form/Label.vue'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { useInitials } from '@/composables/useInitials'
import MainLayout from '@/layouts/MainLayout.vue'
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3'
import {
  AlertTriangleIcon,
  CameraIcon,
  SaveIcon,
  TrashIcon,
  XIcon,
} from 'lucide-vue-next'
import { computed, ref } from 'vue'

const props = defineProps<{
  member: User
}>()

const page = usePage<SharedData>()
const user = page.props.auth.user as User

const { getInitials } = useInitials()

const showAvatar = computed(() => user.avatar && user.avatar !== '')

// State
const confirmDelete = ref(false)
const fileInput = ref(null)

const form = useForm({
  name: props.member.name,
  email: props.member.email,
  phone: props.member.phone,
  location: props.member.location,
  role: props.member.role,
  status: props.member.status,
})

// Open file upload dialog
function openFileUpload() {
  fileInput.value.click()
}

function deleteMember() {
  router.delete(route('team.destroy', [props.member]))
}

function saveMember() {
  form.patch(route('team.update', [props.member]))
}
</script>

<template>
  <MainLayout>
    <Head title="Team" />
    <!-- Page Header with purple accent -->
    <div class="mb-6">
      <div class="border-l-4 border-purple-500 pl-4 mb-4">
        <h1 class="text-3xl font-bold text-purple-900 dark:text-purple-300">
          Edit Team Member
        </h1>
        <p class="mt-1 text-muted-foreground">
          Update member information, role, and access
        </p>
      </div>
    </div>

    <!-- Member Form -->
    <div
      class="rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 p-6 shadow-sm"
    >
      <!-- Member Profile Section -->
      <div class="mb-8">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Profile Information
        </h2>

        <!-- Profile Picture -->
        <div class="flex flex-col sm:flex-row items-center gap-6 mb-6">
          <div class="relative">
            <Avatar class="h-24 w-24 rounded-full object-cover border-2 border-purple-200 dark:border-purple-800">
              <AvatarImage v-if="showAvatar" :src="user.avatar" :alt="user.name" />
              <AvatarFallback>
                {{ getInitials(user.name) }}
              </AvatarFallback>
            </Avatar>
            <button
              class="absolute bottom-0 right-0 rounded-full bg-purple-600 p-1.5 text-white hover:bg-purple-700"
              @click="openFileUpload"
            >
              <CameraIcon class="h-4 w-4" />
            </button>
            <input
              ref="fileInput"
              type="file"
              class="hidden"
              accept="image/*"
            >
          </div>

          <div class="flex-1 space-y-4">
            <!-- Name -->
            <div>
              <Label label="Full Name" assign="member-name" :required="true" />
              <Input
                id="member-name"
                v-model="form.name"
                type="text"
                required
                autofocus
                :tabindex="1"
                autocomplete="name"
                placeholder="Enter full name"
                :error="form.errors.name"
              />
              <InputError :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div>
              <Label label="Email Address" assign="member-email" :required="true" />
              <Input
                id="member-email"
                v-model="form.email"
                type="email"
                required
                :tabindex="2"
                autocomplete="email"
                placeholder="email@example.com"
                :error="form.errors.email"
              />
              <InputError :message="form.errors.email" />
            </div>
          </div>
        </div>

        <!-- Contact Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Phone -->
          <div>
            <Label label="Phone" assign="member-phone" :required="false" />
            <Input
              id="member-phone"
              v-model="form.phone"
              type="tel"
              :tabindex="3"
              placeholder="Enter phone number"
              :error="form.errors.phone"
            />
            <InputError :message="form.errors.phone" />
          </div>

          <!-- Location -->
          <div>
            <Label label="Location" assign="member-location" :required="false" />
            <Input
              id="member-location"
              v-model="form.location"
              type="text"
              :tabindex="4"
              placeholder="City, Country"
              :error="form.errors.location"
            />
            <InputError :message="form.errors.location" />
          </div>
        </div>
      </div>

      <!-- Role & Permissions Section -->
      <div class="mb-8 border-t border-purple-200 dark:border-purple-800 pt-8">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Role & Permissions
        </h2>

        <div class="space-y-6">
          <!-- Role Selection -->
          <div>
            <Label label="Role" assign="member-role" :required="true" />
            <select
              id="member-role"
              v-model="form.role"
              :tabindex="5"
              class="w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900
                py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500
                focus:border-purple-500"
              :class="{ 'border-red-500 dark:border-red-500': form.errors.role }"
            >
              <option value="admin">
                Admin
              </option>
              <option value="member">
                Member
              </option>
            </select>
            <InputError :message="form.errors.role" />

            <!-- Role Description -->
            <div class="mt-2 rounded-md bg-purple-50 dark:bg-purple-900/10 p-3 text-sm text-muted-foreground">
              <div v-if="form.role === 'Admin'">
                <p class="font-medium text-blue-800 dark:text-blue-300">
                  Admin
                </p>
                <p>Can manage team members and projects. Has access to most settings except billing.</p>
              </div>
              <div v-else-if="form.role === 'Member'">
                <p class="font-medium text-gray-800 dark:text-gray-300">
                  Member
                </p>
                <p>Can view and comment on content in assigned projects. Cannot edit content or access settings.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Account Status Section -->
      <div class="mb-8 border-t border-purple-200 dark:border-purple-800 pt-8">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Account Status
        </h2>

        <div class="space-y-4">
          <!-- Status Selection -->
          <div>
            <Label label="Status" assign="member-status" :required="true" />
            <select
              id="member-status"
              v-model="form.status"
              :tabindex="6"
              class="w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900
                py-2 px-3 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500
                focus:border-purple-500"
              :class="{ 'border-red-500 dark:border-red-500': form.errors.status }"
            >
              <option value="active">
                Active
              </option>
              <option value="inactive">
                Inactive
              </option>
            </select>
            <InputError :message="form.errors.status" />
          </div>
          <!-- Deactivation Warning -->
          <div v-if="form.status === 'Inactive'" class="rounded-md bg-red-50 dark:bg-red-900/10 p-4">
            <div class="flex items-start gap-3">
              <AlertTriangleIcon class="h-5 w-5 text-red-600 dark:text-red-400 mt-0.5" />
              <div>
                <h3 class="text-sm font-medium text-red-800 dark:text-red-300">
                  Account Deactivated
                </h3>
                <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                  This user will no longer be able to access the platform. They can be reactivated at any time.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Danger Zone -->
      <div class="border-t border-purple-200 dark:border-purple-800 pt-8">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Danger Zone
        </h2>

        <div class="rounded-md border border-red-200 dark:border-red-800 p-4">
          <h3 class="text-base font-medium text-red-800 dark:text-red-300 mb-2">
            Delete Team Member
          </h3>
          <p class="text-sm text-red-700 dark:text-red-400 mb-4">
            Once you delete a team member, there is no going back. This action cannot be undone.
          </p>
          <button
            class="inline-flex items-center gap-2 rounded-md border border-red-200 dark:border-red-800 bg-white
              dark:bg-gray-900 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50
              dark:hover:bg-red-900/20"
            @click="confirmDelete = true"
          >
            <TrashIcon class="h-4 w-4" />
            <span>Delete Team Member</span>
          </button>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="mt-8 flex items-center justify-end gap-3 border-t border-purple-200 dark:border-purple-800 pt-6">
        <Link
          :href="route('team.index')"
          class="inline-flex items-center gap-2 rounded-md border border-purple-200 dark:border-purple-800 bg-white
            dark:bg-gray-900 px-4 py-2 text-sm font-medium text-foreground hover:bg-purple-50
            dark:hover:bg-purple-900/20"
        >
          Cancel
        </Link>
        <button
          class="inline-flex items-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-4 py-2 text-sm
            font-medium text-white"
          @click="saveMember"
        >
          <SaveIcon class="h-4 w-4" />
          <span>Save Changes</span>
        </button>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="confirmDelete"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    >
      <div
        class="w-full max-w-md rounded-lg border border-red-200 dark:border-red-800 bg-white dark:bg-gray-900 p-6
          shadow-lg"
      >
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-semibold text-red-600 dark:text-red-400">
            Confirm Deletion
          </h2>
          <button
            class="rounded-md p-1.5 text-muted-foreground hover:bg-red-100 dark:hover:bg-red-900/50"
            @click="confirmDelete = false"
          >
            <XIcon class="h-4 w-4" />
          </button>
        </div>

        <div class="mb-6">
          <p class="text-foreground mb-4">
            Are you sure you want to delete <strong>{{ form.name }}</strong>? This action cannot be undone.
          </p>
          <p class="text-sm text-muted-foreground">
            This will permanently remove the team member from your organization and revoke all their access.
          </p>
        </div>

        <div class="flex items-center justify-end gap-3">
          <button
            class="inline-flex items-center gap-2 rounded-md border border-gray-200 dark:border-gray-800 bg-white
              dark:bg-gray-900 px-4 py-2 text-sm font-medium text-foreground hover:bg-gray-50
              dark:hover:bg-gray-800"
            @click="confirmDelete = false"
          >
            Cancel
          </button>
          <button
            class="inline-flex items-center gap-2 rounded-md bg-red-600 hover:bg-red-700 px-4 py-2 text-sm
              font-medium text-white"
            @click="deleteMember"
          >
            <TrashIcon class="h-4 w-4" />
            <span>Delete Member</span>
          </button>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
