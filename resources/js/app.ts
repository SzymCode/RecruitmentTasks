import './bootstrap'
import { createApp } from 'vue'

import 'primevue/resources/themes/lara-light-amber/theme.css'

const app = createApp({})

/**
 *  PrimeVue components
 */
import Button from 'primevue/button'
import Card from 'primevue/card'
import Column from 'primevue/column'
import DataTable from 'primevue/datatable'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'

// eslint-disable-next-line vue/no-reserved-component-names
app.component('Button', Button)
    .component('Card', Card)
    .component('Column', Column)
    .component('DataTable', DataTable)
    .component('Dialog', Dialog)
    .component('InputText', InputText)

/**
 *  Components
 */
import Articles from './components/Articles.vue'
import MyNavbar from './components/MyNavbar.vue'

app.component('articles', Articles)
app.component('my-navbar', MyNavbar)

/**
 *  App uses & mount
 */
import PrimeVue from 'primevue/config'

app.use(PrimeVue).mount('#app')
