<template>
    <div class="container">
        <Card class="articlesCard">
            <template #header>
                <div class="headerContainer">
                    <h2>Articles</h2>
                    <form
                        class="searchForm"
                        id="searchForm"
                        @submit.prevent="searchArticles"
                    >
                        <InputText
                            class="searchInput"
                            v-model="searchTerm"
                            placeholder="Search..."
                        />
                        <Dropdown
                            :options="searchOptions"
                            v-model="selectedSearchOption"
                            class="searchDropdown"
                        />
                    </form>
                </div>
            </template>
            <template #content>
                <DataTable
                    :value="filteredArticles"
                    :rows="10"
                    :row-hover="true"
                    :size="'small'"
                    v-if="filteredArticles"
                    paginator
                    stripedRows
                    paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    currentPageReportTemplate="{first} to {last} of {totalRecords}"
                    @row-click="openModal($event.data)"
                >
                    <Column
                        field="title"
                        :sortable="true"
                        header="Title"
                        class="titleColumn"
                    />
                    <Column
                        field="guid"
                        :sortable="true"
                        header="Guid"
                        class="guidColumn"
                    />
                    <Column
                        field="pub_date"
                        :sortable="true"
                        header="Publication Date"
                        class="pubDateColumn"
                    />
                    <Column
                        field="category"
                        :sortable="true"
                        header="Category"
                        class="categoryColumn"
                    />
                </DataTable>
            </template>
        </Card>
    </div>
    <Dialog
        modal
        :visible="visibleShow"
        v-if="selectedArticle"
        class="showModal"
    >
        <template #header>
            <h3>{{ selectedArticle.title }}</h3>
        </template>
        <div>
            <p><strong>Guid:</strong> {{ selectedArticle.guid }}</p>
            <p>
                <strong>Description:</strong> {{ selectedArticle.description }}
            </p>
            <p>
                <strong>Publication Date:</strong>
                {{ selectedArticle.pub_date }}
            </p>
            <p><strong>Category:</strong> {{ selectedArticle.category }}</p>
        </div>
        <a :href="selectedArticle.link">{{ selectedArticle.link }}</a>

        <template #footer>
            <Button @click="closeModal" label="Close" class="myButton" />
        </template>
    </Dialog>
</template>

<script setup lang="ts">
import { articleApiMethods, useDialog } from '../utils'
import { ref, onMounted } from 'vue'
import { ArticleInterface } from '@/js/types'

const { results: fetchedArticles, getAllArticles } = articleApiMethods()
const { visibleShow, selectedArticle, openModal, closeModal } = useDialog()

const searchTerm = ref('')
const articles = ref<ArticleInterface[]>([])
const filteredArticles = ref<ArticleInterface[]>([])

const searchOptions = ['Title', 'Category']
let selectedSearchOption = ref(searchOptions[0])

onMounted(async () => {
    await getAllArticles()
    if (fetchedArticles.value) {
        articles.value = fetchedArticles.value
        filteredArticles.value = fetchedArticles.value
    }
})

function searchArticles() {
    if (!searchTerm.value.trim()) {
        filteredArticles.value = articles.value
        return
    }

    const searchField =
        selectedSearchOption.value === 'Title' ? 'title' : 'category'

    filteredArticles.value = articles.value.filter((article) =>
        article[searchField]
            .toLowerCase()
            .includes(searchTerm.value.toLowerCase())
    )
}
</script>
