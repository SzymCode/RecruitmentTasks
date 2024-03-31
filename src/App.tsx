import React, { useState, useEffect } from 'react'
import { CircularProgress, Center, Highlight } from '@chakra-ui/react'

import TagTable from './components/TagTable'

const API_URL =
    'https://api.stackexchange.com/2.3/tags?order=desc&sort=popular&site=stackoverflow'

const App: React.FC = () => {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const [tags, setTags] = useState<any[]>([])
    const [loading, setLoading] = useState<boolean>(true)
    const [error, setError] = useState<string | null>(null)

    useEffect(() => {
        fetch(API_URL)
            .then((response) => {
                return response.json()
            })
            .then((data) => {
                setTags(data.items)
                setLoading(false)
            })
            .catch((error) => {
                setError(error.toString())
                setLoading(false)
            })
    }, [])

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
            ) : (
                <TagTable tags={tags} />
            )}
        </Center>
    )
}

export default App
