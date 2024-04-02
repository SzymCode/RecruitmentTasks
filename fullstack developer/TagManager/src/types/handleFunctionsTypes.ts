import {
    SetCurrentPageActionInterface,
    SetErrorActionInterface,
    SetLoadingActionInterface,
    SetTagsActionInterface,
    SetTotalPagesActionInterface,
} from '../types'

export type ActionTypes =
    | SetTagsActionInterface
    | SetLoadingActionInterface
    | SetErrorActionInterface
    | SetCurrentPageActionInterface
    | SetTotalPagesActionInterface
