<script setup lang="ts">
import type { SharedData, User } from '@/types'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { useSidebar } from '@/components/ui/sidebar'
import { useAppearance } from '@/composables/useAppearance'
import { useInitials } from '@/composables/useInitials'
import { Link, usePage } from '@inertiajs/vue3'
import { OnClickOutside } from '@vueuse/components'
import {
  BellIcon,
  ChevronDownIcon,
  FileEditIcon,
  KeyIcon,
  LogOutIcon,
  MenuIcon,
  MessageSquareIcon,
  MoonIcon,
  SearchIcon,
  SettingsIcon,
  SunIcon,
  UserIcon,
  UserPlusIcon,
} from 'lucide-vue-next'
import { computed, ref } from 'vue'

const page = usePage<SharedData>()
const user = page.props.auth.user as User

const { getInitials } = useInitials()

const showAvatar = computed(() => user.avatar && user.avatar !== '')

const notificationIgnore = ref()
const userMenuIgnore = ref()
const options = { ignore: [notificationIgnore, userMenuIgnore] }
const isNotificationsOpen = ref(false)
const isUserMenuOpen = ref(false)
const { appearance, updateAppearance } = useAppearance()
const { toggleSidebar } = useSidebar()

// Sample notifications data
const notifications = ref([
  {
    title: 'New comment on API Documentation',
    time: '2 hours ago',
    icon: MessageSquareIcon,
  },
  {
    title: 'Jane Smith joined the team',
    time: '5 hours ago',
    icon: UserPlusIcon,
  },
  {
    title: 'Authentication Guide was updated',
    time: '1 day ago',
    icon: FileEditIcon,
  },
])

// Toggle theme
function toggleTheme() {
  if (appearance.value === 'light') {
    updateAppearance('dark')
  }
  else {
    updateAppearance('light')
  }
}
</script>

<template>
  <header
    class="flex h-16 items-center justify-between border-b border-purple-200 dark:border-purple-900 bg-white
      dark:bg-gray-950 px-4 md:px-6"
  >
    <div class="flex items-center">
      <button
        class="rounded-md p-1.5 text-purple-600 dark:text-purple-400 hover:bg-purple-100
          dark:hover:bg-purple-900/50"
        @click="toggleSidebar"
      >
        <MenuIcon class="h-5 w-5" />
      </button>
    </div>

    <!-- Search -->
    <div class="relative hidden md:block md:w-1/3">
      <SearchIcon class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-purple-400" />
      <input
        type="search"
        placeholder="Search documentation..."
        class="w-full rounded-md border border-purple-200 dark:border-purple-800 bg-white dark:bg-gray-900 py-2
          pl-10 pr-4 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-purple-500
          focus:border-purple-500"
      >
    </div>

    <!-- Right Side Actions -->
    <div class="flex items-center gap-4">
      <!-- Mobile Search Trigger -->
      <button
        class="rounded-md p-1.5 text-purple-600 dark:text-purple-400 hover:bg-purple-100
          dark:hover:bg-purple-900/50 md:hidden"
      >
        <SearchIcon class="h-5 w-5" />
      </button>

      <!-- Theme Toggle -->
      <button
        class="rounded-md p-1.5 text-purple-600 dark:text-purple-400 hover:bg-purple-100
          dark:hover:bg-purple-900/50"
        aria-label="Toggle theme"
        @click="toggleTheme"
      >
        <SunIcon v-if="appearance === 'dark'" class="h-5 w-5" />
        <MoonIcon v-else class="h-5 w-5" />
      </button>

      <!-- Notifications -->
      <div class="relative">
        <button
          ref="notificationIgnore"
          class="relative rounded-md p-1.5 text-purple-600 dark:text-purple-400 hover:bg-purple-100
          dark:hover:bg-purple-900/50"
          @click="isNotificationsOpen = !isNotificationsOpen"
        >
          <BellIcon class="h-5 w-5" />
          <span class="absolute right-1 top-1 flex h-2 w-2 rounded-full bg-purple-500" />
        </button>

        <!-- Notifications Dropdown -->
        <OnClickOutside
          :options="options"
          @trigger="isNotificationsOpen = false"
        >
          <div
            v-if="isNotificationsOpen"
            class="absolute right-0 top-full z-50 mt-1 w-80 rounded-md border border-purple-200 dark:border-purple-800
            bg-white dark:bg-gray-900 p-4 shadow-lg"
          >
            <h3 class="mb-2 text-sm font-medium text-purple-800 dark:text-purple-300">
              Notifications
            </h3>
            <div class="space-y-4">
              <div
                v-for="(notification, index) in notifications"
                :key="index"
                class="flex gap-3 border-b border-purple-100 dark:border-purple-800 pb-3 last:border-0"
              >
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900">
                  <component :is="notification.icon" class="h-4 w-4 text-purple-600 dark:text-purple-400" />
                </div>
                <div>
                  <p class="text-sm font-medium text-foreground">
                    {{ notification.title }}
                  </p>
                  <p class="text-xs text-muted-foreground">
                    {{ notification.time }}
                  </p>
                </div>
              </div>

              <a
                href="#"
                class="block text-center text-xs font-medium text-purple-600 dark:text-purple-400 hover:underline"
              >
                View all notifications
              </a>
            </div>
          </div>
        </OnClickOutside>
      </div>

      <!-- User Menu -->
      <div class="relative">
        <button
          ref="userMenuIgnore"
          class="flex items-center gap-2 rounded-md p-1.5 text-foreground hover:bg-purple-100
            dark:hover:bg-purple-900/50"
          @click="isUserMenuOpen = !isUserMenuOpen"
        >
          <Avatar class="h-8 w-8 rounded-full ring-2 ring-purple-500">
            <AvatarImage v-if="showAvatar" :src="user.avatar" :alt="user.name" />
            <AvatarFallback>
              {{ getInitials(user.name) }}
            </AvatarFallback>
          </Avatar>
          <span class="hidden text-sm font-medium text-foreground md:block">{{ user.name }}</span>
          <ChevronDownIcon class="hidden h-4 w-4 text-purple-600 dark:text-purple-400 md:block" />
        </button>

        <!-- User Dropdown -->
        <OnClickOutside
          :options="options"
          @trigger="isUserMenuOpen = false"
        >
          <div
            v-if="isUserMenuOpen"
            class="absolute right-0 top-full z-50 mt-1 w-56 rounded-md border border-purple-200 dark:border-purple-800
            bg-white dark:bg-gray-900 p-1 shadow-lg"
          >
            <div class="border-b border-purple-100 dark:border-purple-800 p-2">
              <p class="text-sm font-medium text-foreground">
                {{ user.name }}
              </p>
              <p class="text-xs text-muted-foreground">
                {{ user.email }}
              </p>
            </div>
            <div class="p-1">
              <a
                href="#"
                class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-foreground hover:bg-purple-100
                dark:hover:bg-purple-900/50"
              >
                <UserIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
                <span>Profile</span>
              </a>
              <a
                href="#"
                class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-foreground hover:bg-purple-100
                dark:hover:bg-purple-900/50"
              >
                <SettingsIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
                <span>Settings</span>
              </a>
              <a
                href="#"
                class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-foreground hover:bg-purple-100
                dark:hover:bg-purple-900/50"
              >
                <KeyIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
                <span>API Keys</span>
              </a>
            </div>
            <div class="border-t border-purple-100 dark:border-purple-800 p-1">
              <Link
                :href="route('logout')"
                method="post"
                class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-foreground hover:bg-purple-100 w-full
                dark:hover:bg-purple-900/50"
              >
                <LogOutIcon class="h-4 w-4 text-purple-600 dark:text-purple-400" />
                <span>Log out</span>
              </Link>
            </div>
          </div>
        </OnClickOutside>
      </div>
    </div>
  </header>
</template>
