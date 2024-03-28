<template>
    <div class="container">
        <Card class="articlesCard">
            <template #header>
                <div class="headerContainer">
                    <h2>Articles</h2>

                    <form class="searchForm" id="searchForm">
                        <InputText
                            class="searchInput"
                            placeholder="Search..."
                        />
                        <i class="pi pi-search searchIcon" />
                    </form>
                </div>
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
