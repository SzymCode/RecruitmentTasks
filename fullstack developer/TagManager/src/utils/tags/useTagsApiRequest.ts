import { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import { TagsApiInterface } from '@/types'
import { RootState, AppDispatch, setLoading, setError, setTags } from '@/redux'

export default function useTagsApiRequest(url: string): TagsApiInterface {
    const dispatch = useDispatch<AppDispatch>()

    const { tags, loading, error } = useSelector(
        (state: RootState) => state.data
    )

    useEffect((): void => {
        async function fetchData() {
            try {
                dispatch(setLoading(true))
                const response = await fetch(url)
                const responseData = await response.json()

                if (!response.ok) {
                    const errorMessage =
                        responseData.error_message || response.statusText
                    dispatch(setError(errorMessage))
                } else {
                    dispatch(setTags(responseData.items))
                }
            } catch (error) {
                dispatch(setError('An error occurred'))
            } finally {
                dispatch(setLoading(false))
            }
        }

        fetchData()
    }, [url, dispatch])

    return { tags, loading, error }
}
