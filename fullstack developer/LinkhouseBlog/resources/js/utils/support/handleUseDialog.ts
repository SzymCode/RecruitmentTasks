import { ref, Ref } from 'vue'
import { ArticleInterface, UseDialogInterface } from '@/js/types'

export default function useDialog(): UseDialogInterface {
    const visibleShow: Ref<boolean> = ref(false)
    const selectedArticle: Ref<ArticleInterface | undefined> =
        ref<ArticleInterface>()

    function openModal(object: ArticleInterface): void {
        setSelectedObject(object)

        visibleShow.value = true
    }

    function closeModal(): void {
        visibleShow.value = false
    }

    function setSelectedObject(object: ArticleInterface): void {
        selectedArticle.value = object
    }

    return {
        visibleShow,
        selectedArticle,
        openModal,
        closeModal,
    }
}
