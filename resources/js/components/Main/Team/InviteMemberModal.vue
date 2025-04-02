<script setup lang="ts">
import Input from '@/components/Main/Form/Input.vue'
import InputError from '@/components/Main/Form/InputError.vue'
import Label from '@/components/Main/Form/Label.vue'
import { useTeamMembersStore } from '@/stores/teamMembersStore'
import { useForm } from '@inertiajs/vue3'
import { MailIcon, XIcon } from 'lucide-vue-next'
import { storeToRefs } from 'pinia'

const membersStore = useTeamMembersStore()
const { showInviteModal } = storeToRefs(membersStore)

const form = useForm({
  email: '',
})

function submit() {
  form.post(route('team.invite'), {
    onSuccess: () => {
      form.reset()
      membersStore.closeInviteModal()
    },
  })
}
</script>

<template>
  <div
    v-if="showInviteModal"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
  >
    <div
      class="w-full max-w-md rounded-lg border border-purple-200 dark:border-purple-800 bg-white
          dark:bg-gray-900 p-6 shadow-lg"
    >
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-foreground">
          Invite Team Member
        </h2>
        <button
          class="rounded-md p-1.5 text-muted-foreground hover:bg-purple-100 dark:hover:bg-purple-900/50"
          @click="showInviteModal = false"
        >
          <XIcon class="h-4 w-4" />
        </button>
      </div>
      <!---->
      <div class="space-y-4">
        <!-- Email Input -->
        <div>
          <Label label="Email Address" assign="invite-email" :required="true" />
          <Input
            id="email"
            v-model="form.email"
            type="email"
            required
            autofocus
            :tabindex="1"
            autocomplete="email"
            placeholder="email@example.com"
            :error="form.errors.email"
          />
          <InputError :message="form.errors.email" />
        </div>
      </div>
      <div class="mt-6 flex items-center justify-end gap-3">
        <button
          class="inline-flex items-center gap-2 rounded-md border border-purple-200 dark:border-purple-800
              bg-white dark:bg-gray-900 px-4 py-2 text-sm font-medium text-foreground hover:bg-purple-50
              dark:hover:bg-purple-900/20"
          @click="showInviteModal = false"
        >
          Cancel
        </button>
        <button
          class="inline-flex items-center gap-2 rounded-md bg-purple-600 hover:bg-purple-700 px-4 py-2 text-sm
              font-medium text-white"
          @click="submit"
        >
          <MailIcon class="h-4 w-4" />
          <span>Send Invitation</span>
        </button>
      </div>
    </div>
  </div>
</template>
