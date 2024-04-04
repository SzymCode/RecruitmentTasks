import { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import { setItemsPerPage, setCurrentPage, setTotalPages } from '@/redux'
import { TablePaginationInterface, TagInterface } from '@/types'
import { AppDispatch, RootState } from '@/redux'

export default function useTagsTablePagination(
    tags: TagInterface[]
): TablePaginationInterface {
    const dispatch = useDispatch<AppDispatch>()

    const { itemsPerPage, currentPage, loading, totalPages } = useSelector(
        (state: RootState) => state.data
    )

    useEffect(() => {
        if (tags && (itemsPerPage === null || itemsPerPage <= 10)) {
            const calculatedTotalPages = Math.ceil(
                tags.length / (itemsPerPage || 10)
            )
            dispatch(setTotalPages(calculatedTotalPages))
        }
    }, [dispatch, tags, itemsPerPage])

    function handleChangeItemsPerPage(value: string) {
        if (value === '') {
            dispatch(setItemsPerPage(null!))
        } else {
            let parsedValue = parseInt(value, 10)
            parsedValue = Math.max(parsedValue, 1)
            const newItemsPerPage = Math.min(parsedValue, tags.length)
            dispatch(setItemsPerPage(newItemsPerPage))
            const newTotalPages = Math.ceil(tags.length / newItemsPerPage)
            dispatch(setTotalPages(newTotalPages))
            if (currentPage > newTotalPages) {
                dispatch(setCurrentPage(newTotalPages))
            }
        }
    }

    function handlePrevPage(): void {
        dispatch(setCurrentPage(Math.max(currentPage - 1, 1)))
    }

    function handleNextPage(): void {
        dispatch(setCurrentPage(Math.min(currentPage + 1, totalPages)))
    }

    let currentTags: TagInterface[] = []
    const lastIndex: number = currentPage * (itemsPerPage || 10)
    const firstIndex: number = lastIndex - (itemsPerPage || 10)

    if (tags) {
        currentTags = tags.slice(firstIndex, lastIndex)
    }

    return {
        currentPage,
        loading,
        totalPages,
        currentTags,
        handlePrevPage,
        handleNextPage,
        handleChangeItemsPerPage,
        itemsPerPage,
    }
}
