import { combineReducers } from 'redux'

import { ActionTypes, ReduxDataStateInterface } from '@/types'
import {
    SET_ITEMS_PER_PAGE,
    SET_TAGS,
    SET_LOADING,
    SET_ERROR,
    SET_CURRENT_PAGE,
    SET_TOTAL_PAGES,
    SET_SORT_BY,
    SET_SORT_ORDER,
    initialDataState,
} from '@/constants'

const mainReducer = (
    state: ReduxDataStateInterface = initialDataState,
    action: ActionTypes
): ReduxDataStateInterface => {
    switch (action.type) {
        case SET_ITEMS_PER_PAGE:
            return {
                ...state,
                itemsPerPage:
                    typeof action.payload === 'number' ||
                    action.payload === null
                        ? action.payload
                        : state.itemsPerPage,
            }
        case SET_TAGS:
            return {
                ...state,
                tags: Array.isArray(action.payload) ? action.payload : null,
            }
        case SET_LOADING:
            return {
                ...state,
                loading:
                    typeof action.payload === 'boolean'
                        ? action.payload
                        : state.loading,
            }
        case SET_ERROR:
            return {
                ...state,
                error:
                    typeof action.payload === 'string' ||
                    action.payload === null
                        ? action.payload
                        : state.error,
            }
        case SET_CURRENT_PAGE:
            return {
                ...state,
                currentPage:
                    typeof action.payload === 'number'
                        ? action.payload
                        : state.currentPage,
            }
        case SET_TOTAL_PAGES:
            return {
                ...state,
                totalPages:
                    typeof action.payload === 'number'
                        ? action.payload
                        : state.totalPages,
            }
        case SET_SORT_BY:
            return {
                ...state,
                sortBy:
                    typeof action.payload === 'string' ||
                    typeof action.payload === 'number'
                        ? String(action.payload)
                        : null,
            }
        case SET_SORT_ORDER:
            return {
                ...state,
                sortOrder:
                    action.payload === 'asc' || action.payload === 'desc'
                        ? action.payload
                        : null,
            }
        default:
            return state
    }
}

const rootReducer = combineReducers({
    data: mainReducer,
})

export default rootReducer
