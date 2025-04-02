import {
  ClockIcon,
  MailIcon,
  ShieldIcon,
  UserCheckIcon,
  UserIcon,
} from 'lucide-vue-next'

export function roleIcons() {
  return [
    { name: 'super-admin', component: ShieldIcon },
    { name: 'admin', component: ShieldIcon },
    { name: 'member', component: UserIcon },
  ]
}

export function statusIcons() {
  return [
    { name: 'active', component: UserCheckIcon },
    { name: 'inactive', component: ClockIcon },
    { name: 'pending', component: MailIcon },
  ]
}
