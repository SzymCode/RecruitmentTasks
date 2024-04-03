import {
    SetSortByActionInterface,
    SetSortOrderActionInterface,
    SetCurrentPageActionInterface,
    SetErrorActionInterface,
    SetLoadingActionInterface,
    SetTagsActionInterface,
    SetTotalPagesActionInterface,
} from '@/types'

export type ActionTypes =
    | SetTagsActionInterface
    | SetLoadingActionInterface
    | SetErrorActionInterface
    | SetCurrentPageActionInterface
    | SetTotalPagesActionInterface
    | SetSortByActionInterface
    | SetSortOrderActionInterface

export type SortActionTypes =
    | SetSortByActionInterface
    | SetSortOrderActionInterface
