import {
    SetCurrentPageActionInterface,
    SetErrorActionInterface,
    SetLoadingActionInterface,
    SetTagsActionInterface,
    SetTotalPagesActionInterface,
    TagInterface,
} from '../types'
import {
    SET_CURRENT_PAGE,
    SET_TOTAL_PAGES,
    SET_ERROR,
    SET_LOADING,
    SET_TAGS,
} from '../constants'

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
