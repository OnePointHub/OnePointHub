<script setup lang="ts">
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
} from '@/components/ui/select'
import { useTeamMembersStore } from '@/stores/teamMembersStore'
import { FilterIcon, UserPlusIcon } from 'lucide-vue-next'
import { storeToRefs } from 'pinia'

const membersStore = useTeamMembersStore()
const { filter, showInviteModal } = storeToRefs(membersStore)
</script>

<template>
  <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div class="border-l-4 border-purple-500 pl-4 mb-4 md:mb-0">
      <h1 class="text-3xl font-bold text-purple-900 dark:text-purple-300">
        Team
      </h1>
      <p class="mt-1 text-muted-foreground">
        Manage your team members and their access
      </p>
    </div>
    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-3">
      <div class="relative" data-dropdown="filter">
        <Select v-model="filter">
          <SelectTrigger
            class="inline-flex items-center gap-2 rounded-md bg-white dark:bg-gray-900 px-3 py-2 text-sm font-medium
                text-foreground border border-purple-200 dark:border-purple-800 hover:bg-purple-50
                dark:hover:bg-purple-900/20 focus:ring-0 focus:ring-offset-0"
            :class="{ 'bg-purple-100 dark:bg-purple-900/50': filter !== 'all' }"
          >
            <FilterIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
            <span class="capitalize">{{ filter === 'All' ? 'Filter' : `Role: ${filter}` }}</span>
          </SelectTrigger>
          <SelectContent
            class="rounded-md border border-purple-200
              dark:border-purple-800 bg-white dark:bg-gray-900 p-1 shadow-lg"
          >
            <SelectGroup>
              <SelectItem value="All">
                All
              </SelectItem>
              <SelectItem value="admin">
                Admin
              </SelectItem>
              <SelectItem value="member">
                Member
              </SelectItem>
            </SelectGroup>
          </SelectContent>
        </Select>
      </div>
      <button
        class="inline-flex items-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-3 py-2 text-sm
            font-medium text-white"
        @click="showInviteModal = true"
      >
        <UserPlusIcon class="h-4 w-4" />
        <span>Invite Member</span>
      </button>
    </div>
  </div>
</template>
