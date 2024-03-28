<template>
    <div class="container">
        <Card class="articlesCard">
            <template #header>
                <h2>Articles</h2>
            </template>
            <template #content>
                <DataTable
                    :value="articles"
                    :rows="10"
                    :row-hover="true"
                    :size="'small'"
                    v-if="articles"
                    paginator
                    stripedRows
                    paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                    currentPageReportTemplate="{first} to {last} of {totalRecords}"
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
                        field="link"
                        :sortable="true"
                        header="Link"
                        class="linkColumn"
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
</template>

<script setup lang="ts">
import { articleApiMethods } from '../utils'
import { onMounted } from 'vue'

const { results: articles, getAllArticles } = articleApiMethods()

onMounted(getAllArticles)
</script>
