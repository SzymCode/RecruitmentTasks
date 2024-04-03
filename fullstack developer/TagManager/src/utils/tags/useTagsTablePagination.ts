import { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import { TablePaginationInterface, TagInterface } from '@/types'
import { AppDispatch, RootState, setCurrentPage, setTotalPages } from '@/redux'

export default function useTagsTablePagination(
    tags: TagInterface[],
    ITEMS_PER_PAGE: number
): TablePaginationInterface {
    const dispatch = useDispatch<AppDispatch>()

    const { currentPage, loading, totalPages } = useSelector(
        (state: RootState) => state.data
    )

    useEffect((): void => {
        if (tags) {
            const calculatedTotalPages = Math.ceil(tags.length / ITEMS_PER_PAGE)
            dispatch(setTotalPages(calculatedTotalPages))
        }
    }, [dispatch, tags, ITEMS_PER_PAGE])

    function handlePrevPage(): void {
        dispatch(setCurrentPage(Math.max(currentPage - 1, 1)))
    }

    function handleNextPage(): void {
        dispatch(setCurrentPage(Math.min(currentPage + 1, totalPages)))
    }

    let currentTags: TagInterface[] = []
    const lastIndex: number = currentPage * ITEMS_PER_PAGE
    const firstIndex: number = lastIndex - ITEMS_PER_PAGE

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
    }
}
