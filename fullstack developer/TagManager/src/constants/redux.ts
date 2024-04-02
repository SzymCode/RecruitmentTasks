import { ReduxDataStateInterface } from '../types'

export const initialDataState: ReduxDataStateInterface = {
    tags: null,
    loading: true,
    error: null,
    currentPage: 1,
    totalPages: 1,
}
