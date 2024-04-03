import { useSelector, useDispatch } from 'react-redux'

import { SortTagsInterface, TagInterface } from '@/types'
import { RootState, AppDispatch, setSortBy, setSortOrder } from '@/redux'

export default function useSortTags(): SortTagsInterface {
    const { sortBy, sortOrder } = useSelector((state: RootState) => state.data)
    const dispatch = useDispatch<AppDispatch>()

    function sortTags(tags: TagInterface[]): TagInterface[] {
        if (sortBy === null) return tags

        return tags.slice().sort((a, b) => {
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
