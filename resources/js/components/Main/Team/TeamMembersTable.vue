<script setup lang="ts">
import { roleIcons, statusIcons } from '@/composables/useAvailableIcons'
import { useTeamMembersStore } from '@/stores/teamMembersStore'
import {
  UserIcon,
  UserPlusIcon,
  UsersIcon,
} from 'lucide-vue-next'
import { storeToRefs } from 'pinia'
import { inject } from 'vue'

const membersStore = useTeamMembersStore()
const { filteredMembers, showInviteModal } = storeToRefs(membersStore)
const selectMember = inject('selectMember')

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
    case 'Super-Admin':
      return 'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300'
    case 'admin':
      return 'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300'
    case 'member':
      return 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300'
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
</script>

<template>
  <!-- Team Members Table -->
  <div
    class="rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900
        overflow-hidden"
  >
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-purple-100 dark:border-purple-800 bg-purple-50 dark:bg-purple-900/20">
            <th
              class="px-4 py-3 text-left text-xs font-medium text-purple-800 dark:text-purple-300 uppercase
                  tracking-wider"
            >
              Member
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-medium text-purple-800 dark:text-purple-300 uppercase
                  tracking-wider"
            >
              Role
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-medium text-purple-800 dark:text-purple-300 uppercase
                  tracking-wider"
            >
              Status
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-medium text-purple-800 dark:text-purple-300 uppercase
                  tracking-wider"
            >
              Last Active
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-purple-100 dark:divide-purple-800">
          <tr
            v-for="(member, index) in filteredMembers"
            :key="index"
            class="hover:bg-purple-50 dark:hover:bg-purple-900/10 cursor-pointer"
            @click="selectMember = member"
          >
            <td class="px-4 py-4 whitespace-nowrap">
              <div class="flex items-center gap-3">
                <img
                  :src="`https://ui-avatars.com/api/?name=${member.name}&background=6d28d9&color=fff`"
                  :alt="member.name"
                  class="h-10 w-10 rounded-full"
                >
                <div>
                  <p class="font-medium text-foreground">
                    {{ member.name }}
                  </p>
                  <p class="text-xs text-muted-foreground">
                    {{ member.email }}
                  </p>
                </div>
              </div>
            </td>
            <td class="px-4 py-4 whitespace-nowrap">
              <div
                class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
                :class="getRoleBadgeClass(member.role)"
              >
                <component :is="getRoleIcon(member.role)" class="h-3 w-3" />
                <span class="capitalize">{{ member.role }}</span>
              </div>
            </td>
            <td class="px-4 py-4 whitespace-nowrap">
              <div
                class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
                :class="getStatusBadgeClass(member.status)"
              >
                <component :is="getStatusIcon(member.status)" class="h-3 w-3" />
                <span class="capitalize">{{ member.status }}</span>
              </div>
            </td>
            <td class="px-4 py-4 whitespace-nowrap text-sm text-muted-foreground">
              {{ member.last_active }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Empty State (shown when no members match filter) -->
  <div
    v-if="filteredMembers.length === 0"
    class="flex flex-col items-center justify-center rounded-lg border border-dashed border-purple-200
        dark:border-purple-800 bg-white dark:bg-gray-900 p-12 text-center"
  >
    <div class="mb-4 rounded-full bg-purple-100 dark:bg-purple-900/50 p-4">
      <UsersIcon class="h-8 w-8 text-purple-600 dark:text-purple-400" />
    </div>
    <h3 class="mb-2 text-xl font-medium text-foreground">
      No team members found
    </h3>
    <p class="mb-6 max-w-md text-muted-foreground">
      Get started by inviting team members to collaborate on your projects.
    </p>
    <button
      class="inline-flex items-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-4 py-2 text-sm
          font-medium text-white"
      @click="showInviteModal = true"
    >
      <UserPlusIcon class="h-4 w-4" />
      <span>Invite Team Members</span>
    </button>
  </div>
</template>
