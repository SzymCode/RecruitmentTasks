import './bootstrap'
import { createApp } from 'vue'

import 'primevue/resources/themes/lara-light-green/theme.css'

const app = createApp({})

/**
 *  Components
 */
import ExampleComponent from './components/ExampleComponent.vue'

app.component('example-component', ExampleComponent)

/**
 *  App uses & mount
 */
import PrimeVue from 'primevue/config'

app.use(PrimeVue).mount('#app')
