import { ReduxDataStateInterface } from '@/types'

export const initialDataState: ReduxDataStateInterface = {
    itemsPerPage: 10,
    tags: null,
    loading: true,
    error: null,
    currentPage: 1,
    totalPages: 1,
    sortBy: null,
    sortOrder: null,
}
