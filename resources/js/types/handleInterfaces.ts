import { Ref } from 'vue'

export interface ArticleApiMethodsInterface {
    results: Ref<ArticleInterface[] | undefined>
    getAllArticles: () => Promise<ArticleInterface[]>
}

export interface ArticleInterface {
    id: number
    guid: string
    title: string
    link: string
    description: string
    category?: string
    pub_date: string
}
