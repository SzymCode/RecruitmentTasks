import React from 'react'
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
    Card,
    Heading,
    Center,
    Input,
} from '@chakra-ui/react'

import { TagInterface, TagTableInterface } from '@/types'
import { useSortTags, useTagsTablePagination } from '@/utils'

export default function TagTable({
    tags,
}: TagTableInterface): React.JSX.Element {
    const {
        currentPage,
        totalPages,
        currentTags,
        itemsPerPage,
        handleChangeItemsPerPage,
        handlePrevPage,
        handleNextPage,
    } = useTagsTablePagination(tags)

    const { handleSortBy, sortBy, sortOrder, sortTags } = useSortTags()

    return (
        <VStack
            align="stretch"
            spacing="4"
            backgroundColor="white"
            padding="4"
            position="absolute"
            top="100px"
            paddingBottom="100px"
        >
            <Card padding="20px 80px" gap="20px">
                <Heading margin="auto">Tags</Heading>
                <Center>
                    <Input
                        type="text"
                        value={itemsPerPage === null ? '' : itemsPerPage}
                        onChange={(e) => {
                            const value = e.target.value

                            if (value === '' || /^\d+$/.test(value)) {
                                handleChangeItemsPerPage(value)
                            }
                        }}
                        placeholder="Items per page"
                    />
                </Center>
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
                                <Th
                                    onClick={() => handleSortBy('name')}
                                    cursor="pointer"
                                >
                                    Tag Name{' '}
                                    {sortBy === 'name' &&
                                        (sortOrder && sortOrder === 'asc'
                                            ? '↑'
                                            : '↓')}
                                </Th>
                                <Th
                                    onClick={() => handleSortBy('count')}
                                    cursor="pointer"
                                >
                                    Count{' '}
                                    {sortBy === 'count' &&
                                        (sortOrder && sortOrder === 'asc'
                                            ? '↑'
                                            : '↓')}
                                </Th>
                            </Tr>
                        </Thead>
                        <Tbody>
                            {sortTags(
                                currentPage,
                                itemsPerPage!,
                                tags,
                                currentTags
                            ).map((tag: TagInterface) => (
                                <Tr key={tag.name}>
                                    <Td padding="10px 20px">{tag.name}</Td>
                                    <Td padding="10px 20px">{tag.count}</Td>
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
        </VStack>
    )
}
