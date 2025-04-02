import type { User } from '@/types'
import { defineStore } from 'pinia'

export const useTeamMembersStore = defineStore('teamMembers', {
  state: () => {
    return {
      members: [] as Array<User>,
      filter: 'All',
      showInviteModal: false,
    }
  },
  getters: {
    filteredMembers(state) {
      if (state.filter !== 'All') {
        return state.members.filter((member: User) => member.role === state.filter)
      }
      else {
        return state.members
      }
    },
  },
  actions: {
    clearMembers() {
      this.members = []
    },
    addMembers(member: User) {
      this.members.push(member)
    },
    closeInviteModal() {
      this.showInviteModal = false
    },
  },
})
