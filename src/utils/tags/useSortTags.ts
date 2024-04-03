import { useSelector, useDispatch } from 'react-redux'

import { SortTagsInterface, TagInterface } from '@/types'
import { RootState, AppDispatch, setSortBy, setSortOrder } from '@/redux'

export default function useSortTags(): SortTagsInterface {
    const { sortBy, sortOrder } = useSelector((state: RootState) => state.data)
    const dispatch = useDispatch<AppDispatch>()

    function sortTags(
        currentPage: number,
        itemsPerPage: number,
        tags: TagInterface[],
        currentTags?: TagInterface[]
    ): TagInterface[] {
        if (sortBy === null) return currentTags!.slice()

        const sortingTags = tags.slice().sort((a, b) => {
            if (sortBy === 'name') {
                const comparison = a.name.localeCompare(b.name)
                return sortOrder === 'asc' ? comparison : -comparison
            } else if (sortBy === 'count') {
                return sortOrder === 'asc'
                    ? a.count - b.count
                    : b.count - a.count
            }
            return 0
        })

        const startIndex = (currentPage - 1) * itemsPerPage
        const endIndex = Math.min(
            startIndex + itemsPerPage,
            startIndex + 10,
            sortingTags.length
        )

        return sortingTags.slice(startIndex, endIndex)
    }

    function handleSortBy(field: string): void {
        dispatch(setSortBy(field))
        if (sortBy === field) {
            dispatch(setSortOrder(sortOrder === 'asc' ? 'desc' : 'asc'))
        } else {
            dispatch(setSortOrder('asc'))
        }
    }

    return { sortBy, sortOrder, sortTags, handleSortBy }
}
