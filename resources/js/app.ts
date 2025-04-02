import type { DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createPinia } from 'pinia'
import { createApp, h } from 'vue'
import Vue3Toastify from 'vue3-toastify'
import { ZiggyVue } from 'ziggy-js'
import { initializeTheme } from './composables/useAppearance'
import 'vue3-toastify/dist/index.css'
import '../css/app.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'
const pinia = createPinia()

createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: name => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(Vue3Toastify)
      .use(pinia)
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})

// This will set light / dark mode on page load...
initializeTheme()
