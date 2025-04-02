<script setup lang="ts">
import type { User } from '@/types'
import { roleIcons, statusIcons } from '@/composables/useAvailableIcons'
import { Link } from '@inertiajs/vue3'
import { EditIcon, MailIcon, MapPinIcon, PhoneIcon, UserIcon, XIcon } from 'lucide-vue-next'
import { inject } from 'vue'

const selectedMember = inject<User | null>('selectMember')

const roleIcon = roleIcons()
const statusIcon = statusIcons()

// Get role icon
function getRoleIcon(iconName: string) {
  const icon = roleIcon.find(i => i.name === iconName)
  return icon ? icon.component : UserIcon
}

// Get status icon
function getStatusIcon(status: string) {
  const icon = statusIcon.find(i => i.name === status)
  return icon ? icon.component : UserIcon
}

// Get role badge class
function getRoleBadgeClass(role: string) {
  switch (role) {
    case 'super-admin':
      return 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300'
    case 'admin':
      return 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300'
    case 'member':
      return 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300'
  }
}

// Get status badge class
function getStatusBadgeClass(status: string) {
  switch (status) {
    case 'active':
      return 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300'
    case 'inactive':
      return 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300'
    case 'pending':
      return 'bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-300'
    default:
      return 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300'
  }
}

// Resend invite
function resendInvite(member: User) {
  // In a real app, this would trigger an API call to resend the invitation
  console.warn('Resend invite to:', member)
  // activeMemberMenu.value = null
}
</script>

<template>
  <div
    v-if="selectedMember"
    class="fixed inset-y-0 right-0 z-30 w-80 border-l border-purple-200 dark:border-purple-900 bg-white
        dark:bg-gray-950 overflow-y-auto transition-transform duration-300 transform"
    :class="{ 'translate-x-0': selectedMember, 'translate-x-full': !selectedMember }"
  >
    <div class="p-4">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-foreground">
          Member Details
        </h2>
        <button
          class="rounded-md p-1.5 text-muted-foreground hover:bg-purple-100 dark:hover:bg-purple-900/50"
          @click="selectedMember = null"
        >
          <XIcon class="h-4 w-4" />
        </button>
      </div>
      <div class="flex flex-col items-center mb-6">
        <img
          :src="`https://ui-avatars.com/api/?name=${selectedMember!.name}&background=6d28d9&color=fff&size=128`"
          :alt="selectedMember!.name"
          class="h-24 w-24 rounded-full mb-3"
        >
        <h3 class="text-xl font-medium text-foreground">
          {{ selectedMember.name }}
        </h3>
        <p class="text-sm text-muted-foreground">
          {{ selectedMember.email }}
        </p>
        <div class="mt-3 flex items-center gap-2">
          <div
            class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
            :class="getRoleBadgeClass(selectedMember!.role)"
          >
            <component :is="getRoleIcon(selectedMember!.role)" class="h-3 w-3" />
            <span class="capitalize">{{ selectedMember.role }}</span>
          </div>
          <div
            class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
            :class="getStatusBadgeClass(selectedMember!.status)"
          >
            <component :is="getStatusIcon(selectedMember!.status)" class="h-3 w-3" />
            <span class="capitalize">{{ selectedMember.status }}</span>
          </div>
        </div>
      </div>
      <!-- Member Info -->
      <div class="space-y-6">
        <!-- Contact Info -->
        <div>
          <h4 class="text-sm font-medium text-foreground mb-2">
            Contact Information
          </h4>
          <div
            class="rounded-md border border-purple-200 dark:border-purple-800 bg-purple-50/50
                dark:bg-purple-900/10 p-3 space-y-2"
          >
            <div class="flex items-center gap-2">
              <MailIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
              <span class="text-sm text-foreground">{{ selectedMember.email }}</span>
            </div>
            <div v-if="selectedMember!.phone" class="flex items-center gap-2">
              <PhoneIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
              <span class="text-sm text-foreground">{{ selectedMember.phone }}</span>
            </div>
            <div v-if="selectedMember!.location" class="flex items-center gap-2">
              <MapPinIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
              <span class="text-sm text-foreground">{{ selectedMember.location }}</span>
            </div>
          </div>
        </div>
        <!-- Actions -->
        <div class="flex flex-col gap-2 pt-4 border-t border-purple-200 dark:border-purple-800">
          <Link
            class="inline-flex items-center justify-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-4
                py-2 text-sm font-medium text-white"
            :href="route('team.edit', [selectedMember])"
          >
            <EditIcon class="h-4 w-4" />
            <span>Edit Member</span>
          </Link>
          <button
            v-if="selectedMember!.status === 'pending'"
            class="inline-flex items-center justify-center gap-2 rounded-md border border-purple-200
                dark:border-purple-800 bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-foreground
                hover:bg-purple-50 dark:hover:bg-purple-900/20"
            @click="resendInvite(selectedMember)"
          >
            <MailIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
            <span>Resend Invite</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
