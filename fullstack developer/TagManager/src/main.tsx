import React from 'react'
import { ChakraProvider } from '@chakra-ui/react'
import * as ReactDOM from 'react-dom/client'

import App from './App.tsx'
import './index.css'

const rootElement: HTMLElement = document.getElementById('root')!

ReactDOM.createRoot(rootElement).render(
    <React.StrictMode>
        <ChakraProvider>
            <App />
        </ChakraProvider>
    </React.StrictMode>
)
