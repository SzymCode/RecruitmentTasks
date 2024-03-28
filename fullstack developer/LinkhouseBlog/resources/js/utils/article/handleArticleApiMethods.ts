import axios from 'axios'
import { ref, Ref } from 'vue'

import {
    ArticleApiMethodsInterface,
    GetAllArticlesAxiosFunctionType,
    GetAllArticlesFunctionType,
    ArticleInterface,
} from '../../types'

export default function articleApiMethods(): ArticleApiMethodsInterface {
    const results: Ref<ArticleInterface[] | undefined> = ref([])

    function getAllArticles(): GetAllArticlesFunctionType {
        return axios
            .get('/articles')
            .then((response: GetAllArticlesAxiosFunctionType) => {
                return (results.value = response.data)
            })
            .catch((error) => {
                return error
            })
    }

    return { results, getAllArticles }
}
