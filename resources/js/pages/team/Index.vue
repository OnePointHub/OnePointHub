<script setup lang="ts">
import type { User } from '@/types'
import InviteMemberModal from '@/components/Main/Team/InviteMemberModal.vue'
import TeamHeader from '@/components/Main/Team/TeamHeader.vue'
import TeamMemberDetails from '@/components/Main/Team/TeamMemberDetails.vue'
import TeamMembersTable from '@/components/Main/Team/TeamMembersTable.vue'
import TeamStats from '@/components/Main/Team/TeamStats.vue'
import MainLayout from '@/layouts/MainLayout.vue'
import { useTeamMembersStore } from '@/stores/teamMembersStore'
import { Head } from '@inertiajs/vue3'
import { onMounted, provide, ref } from 'vue'

const props = defineProps<{
  members: User[]
}>()

const storeMembers = useTeamMembersStore()
onMounted(() => {
  storeMembers.clearMembers()
  props.members.forEach((value) => {
    storeMembers.addMembers(value)
  })
})
const selectMember = ref<User | null>(null)

provide('selectMember', selectMember)
</script>

<template>
  <MainLayout>
    <Head title="Team" />
    <TeamHeader />
    <TeamStats />
    <TeamMembersTable />
    <TeamMemberDetails />
    <InviteMemberModal />
  </MainLayout>
</template>
