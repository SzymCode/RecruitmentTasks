import React, { useState, useEffect } from 'react'
import {
    Table,
    Thead,
    Tbody,
    Tr,
    Th,
    Td,
    Text,
    Button,
    HStack,
    VStack,
    CircularProgress,
    Card,
    Heading,
    Center,
} from '@chakra-ui/react'

interface Tag {
    name: string
    count: number
}

interface TagTableProps {
    tags: Tag[]
}

const ITEMS_PER_PAGE = 10

const TagTable: React.FC<TagTableProps> = ({ tags }) => {
    const [currentPage, setCurrentPage] = useState<number>(1)
    const [loading, setLoading] = useState<boolean>(true)

    useEffect(() => {
        setLoading(false)
    }, [])

    const totalPages = Math.ceil(tags.length / ITEMS_PER_PAGE)

    const lastIndex = currentPage * ITEMS_PER_PAGE
    const firstIndex = lastIndex - ITEMS_PER_PAGE
    const currentTags = tags.slice(firstIndex, lastIndex)

    function handlePrevPage() {
        setCurrentPage((prevPage) => Math.max(prevPage - 1, 1))
    }

    function handleNextPage() {
        setCurrentPage((prevPage) => Math.min(prevPage + 1, totalPages))
    }

    return (
        <VStack align="stretch" spacing="4" backgroundColor="white" padding="4">
            {loading ? (
                <CircularProgress isIndeterminate color="green.300" />
            ) : (
                <Card padding="20px 80px" gap="20px">
                    <Heading margin="auto">Tags</Heading>
                    <Center>
                        <Table
                            variant="striped"
                            colorScheme="green"
                            padding="5px"
                            borderWidth="1px"
                            borderColor="green.100"
                            maxWidth="fit-content"
                        >
                            <Thead>
                                <Tr>
                                    <Th>Tag Name</Th>
                                    <Th>Count</Th>
                                </Tr>
                            </Thead>
                            <Tbody>
                                {currentTags.map((tag) => (
                                    <Tr key={tag.name}>
                                        <Td>{tag.name}</Td>
                                        <Td>{tag.count}</Td>
                                    </Tr>
                                ))}
                            </Tbody>
                        </Table>
                    </Center>

                    <HStack justify="center" spacing="4">
                        <Button
                            onClick={handlePrevPage}
                            disabled={currentPage === 1}
                        >
                            Prev
                        </Button>
                        <Text>
                            {currentPage} / {totalPages}
                        </Text>
                        <Button
                            onClick={handleNextPage}
                            disabled={currentPage === totalPages}
                        >
                            Next
                        </Button>
                    </HStack>
                </Card>
            )}
        </VStack>
    )
}

export default TagTable
