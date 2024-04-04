import { Meta, StoryFn } from '@storybook/react'
import { ChakraProvider } from '@chakra-ui/react'
import { Provider } from 'react-redux'

import { TagTable } from '@/components'
import { store } from '@/redux'

export default {
    component: TagTable,
} as Meta
const mockedTags = [
    { name: 'Tag 1', count: 1 },
    { name: 'Tag 2', count: 20 },
    { name: 'Tag 3', count: 300 },
    { name: 'Tag 4', count: 4000 },
    { name: 'Tag 5', count: 50000 },
    { name: 'Tag 6', count: 600000 },
    { name: 'Tag 7', count: 7000000 },
    { name: 'Tag 8', count: 80000000 },
    { name: 'Tag 9', count: 900000000 },
    { name: 'Tag 10', count: 1000000000 },
    { name: 'Tag 11', count: 11 },
    { name: 'Tag 22', count: 22 },
    { name: 'Tag 33', count: 330 },
    { name: 'Tag 44', count: 4400 },
    { name: 'Tag 55', count: 550000 },
    { name: 'Tag 66', count: 660000 },
    { name: 'Tag 77', count: 7700000 },
    { name: 'Tag 88', count: 88000000 },
    { name: 'Tag 99', count: 990000000 },
    { name: 'Tag 110', count: 11000000000 },
]

export const Primary: StoryFn = () => (
    <ChakraProvider>
        <Provider store={store}>
    <TagTable tags={mockedTags} />
</Provider>
</ChakraProvider>
)
