<script setup lang="ts">
import { useTeamMembersStore } from '@/stores/teamMembersStore'
import { ClockIcon, ShieldIcon, UserCheckIcon, UsersIcon } from 'lucide-vue-next'

const membersStore = useTeamMembersStore()
</script>

<template>
  <div class="grid gap-4 mb-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
    <div
      class="rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 p-4
          shadow-sm"
    >
      <div class="flex items-center gap-3">
        <div class="rounded-md bg-purple-100 dark:bg-purple-900/50 p-2">
          <UsersIcon class="h-5 w-5 text-purple-600 dark:text-purple-400" />
        </div>
        <div>
          <p class="text-sm text-muted-foreground">
            Total Members
          </p>
          <p class="text-2xl font-bold text-foreground">
            {{ membersStore.members.length }}
          </p>
        </div>
      </div>
    </div>

    <div
      class="rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 p-4
          shadow-sm"
    >
      <div class="flex items-center gap-3">
        <div class="rounded-md bg-blue-100 dark:bg-blue-900/50 p-2">
          <ShieldIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
        </div>
        <div>
          <p class="text-sm text-muted-foreground">
            Admins
          </p>
          <p class="text-2xl font-bold text-foreground">
            {{ membersStore.members.filter(m => m.role === 'admin').length }}
          </p>
        </div>
      </div>
    </div>

    <div
      class="rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 p-4
          shadow-sm"
    >
      <div class="flex items-center gap-3">
        <div class="rounded-md bg-green-100 dark:bg-green-900/50 p-2">
          <UserCheckIcon class="h-5 w-5 text-green-600 dark:text-green-400" />
        </div>
        <div>
          <p class="text-sm text-muted-foreground">
            Active Members
          </p>
          <p class="text-2xl font-bold text-foreground">
            {{ membersStore.members.filter(m => m.status === 'active').length }}
          </p>
        </div>
      </div>
    </div>

    <div
      class="rounded-lg border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 p-4
          shadow-sm"
    >
      <div class="flex items-center gap-3">
        <div class="rounded-md bg-orange-100 dark:bg-orange-900/50 p-2">
          <ClockIcon class="h-5 w-5 text-orange-600 dark:text-orange-400" />
        </div>
        <div>
          <p class="text-sm text-muted-foreground">
            Pending Invites
          </p>
          <p class="text-2xl font-bold text-foreground">
            {{ membersStore.members.filter(m => m.status === 'pending').length }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
