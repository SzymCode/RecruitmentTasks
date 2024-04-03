import {
    SetCurrentPageActionInterface,
    SetErrorActionInterface,
    SetLoadingActionInterface,
    SetTagsActionInterface,
    SetTotalPagesActionInterface,
    SetItemsPerPageActionInterface,
    TagInterface,
    SortActionTypes,
} from '@/types'
import {
    SET_CURRENT_PAGE,
    SET_TOTAL_PAGES,
    SET_ERROR,
    SET_LOADING,
    SET_TAGS,
    SET_ITEMS_PER_PAGE,
    SET_SORT_BY,
    SET_SORT_ORDER,
} from '@/constants'

export const setSortBy = (sortBy: string | null): SortActionTypes => ({
    type: SET_SORT_BY,
    payload: sortBy,
})

export const setSortOrder = (sortOrder: 'asc' | 'desc'): SortActionTypes => ({
    type: SET_SORT_ORDER,
    payload: sortOrder,
})

export function setItemsPerPage(
    itemsPerPage: number
): SetItemsPerPageActionInterface {
    return {
        type: SET_ITEMS_PER_PAGE,
        payload: itemsPerPage,
    }
}

export function setCurrentPage(
    currentPage: number
): SetCurrentPageActionInterface {
    return {
        type: SET_CURRENT_PAGE,
        payload: currentPage,
    }
}

export function setTotalPages(
    totalPages: number
): SetTotalPagesActionInterface {
    return {
        type: SET_TOTAL_PAGES,
        payload: totalPages,
    }
}

export function setTags(tags: TagInterface[]): SetTagsActionInterface {
    return {
        type: SET_TAGS,
        payload: tags,
    }
}

export function setLoading(loading: boolean): SetLoadingActionInterface {
    return {
        type: SET_LOADING,
        payload: loading,
    }
}

export function setError(error: string): SetErrorActionInterface {
    return {
        type: SET_ERROR,
        payload: error,
    }
}
