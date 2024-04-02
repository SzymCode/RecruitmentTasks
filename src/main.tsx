import React from 'react'
import { ChakraProvider } from '@chakra-ui/react'
import * as ReactDOM from 'react-dom/client'
import { Provider } from 'react-redux'

import App from './App.tsx'
import { store } from './redux'

const rootElement: HTMLElement = document.getElementById('root')!

ReactDOM.createRoot(rootElement).render(
    <React.StrictMode>
        <ChakraProvider>
            <Provider store={store}>
                <App />
            </Provider>
        </ChakraProvider>
    </React.StrictMode>
)
