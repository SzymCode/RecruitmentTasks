import {
    SET_CURRENT_PAGE,
    SET_TOTAL_PAGES,
    SET_ERROR,
    SET_LOADING,
    SET_TAGS,
} from '../constants'

/**
 *  Actions
 */
export interface SetCurrentPageActionInterface {
    type: typeof SET_CURRENT_PAGE
    payload: number
}

export interface SetTotalPagesActionInterface {
    type: typeof SET_TOTAL_PAGES
    payload: number
}

export interface SetTagsActionInterface {
    type: typeof SET_TAGS
    payload: TagInterface[] | null
}

export interface SetLoadingActionInterface {
    type: typeof SET_LOADING
    payload: boolean
}

export interface SetErrorActionInterface {
    type: typeof SET_ERROR
    payload: string | null
}

/**
 *  Api
 */
export interface TagsApiInterface {
    tags: TagInterface[] | null
    loading: boolean
    error: string | null
}

/**
 *  Pagination
 */
export interface TablePaginationInterface {
    currentPage: number
    loading: boolean
    totalPages: number
    currentTags?: TagInterface[]
    handlePrevPage: () => void
    handleNextPage: () => void
}

/**
 *  Redux data
 */
export interface ReduxDataStateInterface {
    tags: TagInterface[] | null
    loading: boolean
    error: string | null
    currentPage: number
    totalPages: number
}

/**
 *  Tags
 */
export interface TagInterface {
    name: string
    count: number
}

export interface TagTableInterface {
    tags: TagInterface[]
}
