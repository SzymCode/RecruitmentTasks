import './bootstrap'
import { createApp } from 'vue'

import 'primevue/resources/themes/lara-light-green/theme.css'

const app = createApp({})

/**
 *  Components
 */
import MyNavbar from './components/MyNavbar.vue'

app.component('my-navbar', MyNavbar)

/**
 *  App uses & mount
 */
import PrimeVue from 'primevue/config'

app.use(PrimeVue).mount('#app')
