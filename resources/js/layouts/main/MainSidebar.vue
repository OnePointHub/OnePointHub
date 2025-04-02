<script setup lang="ts">
import type { NavItem, SharedData } from '@/types'
import AppLogo from '@/components/Main/AppLogo.vue'
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar'
import { Link, usePage } from '@inertiajs/vue3'
import { HelpCircle, LayoutDashboard, Settings, Users } from 'lucide-vue-next'

const page = usePage<SharedData>()

const items: NavItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
    icon: LayoutDashboard,
  },
  {
    title: 'Team',
    href: '/team',
    icon: Users,
  },
]

// const spaces: NavItem[] = [
//   {
//     title: 'All Spaces',
//     href: '/spaces',
//     icon: Layers,
//   },
//   {
//     title: 'Engineering',
//     href: '/spaces/engineering',
//     icon: Hash,
//   },
//   {
//     title: 'Product',
//     href: '/spaces/product',
//     icon: Hash,
//   },
//   {
//     title: 'Design',
//     href: '/spaces/design',
//     icon: Hash,
//   },
// ]

const footerItems: NavItem[] = [
  {
    title: 'Settings',
    href: '/settings',
    icon: Settings,
  },
  {
    title: 'Help & Support',
    href: '#',
    icon: HelpCircle,
  },
]
</script>

<template>
  <Sidebar variant="sidebar">
    <SidebarHeader class="bg-gradient-to-r from-purple-600 to-purple-500">
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child class="hover:bg-transparent">
            <Link :href="route('dashboard')">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>
    <SidebarContent>
      <SidebarGroup>
        <SidebarGroupLabel
          class="text-xs px-3 tracking-wider font-semibold uppercase text-purple-700 dark:text-purple-300"
        >
          Main
        </SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem
              v-for="item in items"
              :key="item.title"
              class="font-medium text-sm"
            >
              <SidebarMenuButton
                as-child
                :is-active="item.href === page.url"
              >
                <Link :href="item.href">
                  <component :is="item.icon" class="text-purple-600 dark:text-purple-400" />
                  <span>{{ item.title }}</span>
                </Link>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
      <!-- <SidebarGroup> -->
      <!--   <SidebarGroupLabel -->
      <!--     class="text-xs px-3 tracking-wider font-semibold uppercase text-purple-700 dark:text-purple-300" -->
      <!--   > -->
      <!--     Spaces -->
      <!--   </SidebarGroupLabel> -->
      <!--   <SidebarGroupContent> -->
      <!--     <SidebarMenu> -->
      <!--       <SidebarMenuItem -->
      <!--         v-for="space in spaces" -->
      <!--         :key="space.title" -->
      <!--         class="font-medium text-sm" -->
      <!--       > -->
      <!--         <SidebarMenuButton -->
      <!--           as-child -->
      <!--           :is-active="space.href === page.url" -->
      <!--         > -->
      <!--           <Link :href="space.href"> -->
      <!--             <component :is="space.icon" class="text-purple-600 dark:text-purple-400" /> -->
      <!--             <span>{{ space.title }}</span> -->
      <!--           </Link> -->
      <!--         </SidebarMenuButton> -->
      <!--       </SidebarMenuItem> -->
      <!--     </SidebarMenu> -->
      <!--   </SidebarGroupContent> -->
      <!-- </SidebarGroup> -->
    </SidebarContent>
    <SidebarFooter>
      <SidebarMenu>
        <SidebarMenuItem
          v-for="footer in footerItems"
          :key="footer.title"
          class="font-medium text-sm"
        >
          <SidebarMenuButton
            as-child
            :is-active="footer.href === page.url"
          >
            <Link :href="footer.href">
              <component :is="footer.icon" class="text-purple-600 dark:text-purple-400" />
              <span>{{ footer.title }}</span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarFooter>
  </Sidebar>
</template>
