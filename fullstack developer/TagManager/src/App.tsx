import React from 'react'
import { CircularProgress, Center, Highlight } from '@chakra-ui/react'

import TagTable from './components/TagTable'
import { useTagsApiRequest } from './utils'
import { API_URL } from './constants'

export default function App(): React.JSX.Element {
    const { tags, error, loading } = useTagsApiRequest(API_URL)

    return (
        <Center h="100vh">
            {loading ? (
                <CircularProgress isIndeterminate color="green.300" />
            ) : error ? (
                <Highlight
                    styles={{
                        px: '3',
                        py: '2',
                        rounded: 'full',
                        bg: 'red.100',
                    }}
                    query={error}
                >
                    {error}
                </Highlight>
            ) : tags ? (
                <TagTable tags={tags} />
            ) : (
                <Highlight
                    styles={{
                        px: '3',
                        py: '2',
                        rounded: 'full',
                        bg: 'red.100',
                    }}
                    query="Cant find error"
                >
                    Cant find error
                </Highlight>
            )}
        </Center>
    )
}
