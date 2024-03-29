import { Ref } from 'vue'

/**
 *  Articles
 */
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

/**
 *  useModal
 */
export interface UseDialogInterface {
    visibleShow: Ref<boolean>
    selectedArticle: Ref<ArticleInterface | undefined>
    openModal: (object: ArticleInterface) => void
    closeModal: () => void
}
