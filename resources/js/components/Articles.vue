<template>
    <div class="container">
        <Card>
            <template #content>
                <DataTable :row-hover="true" :size="'small'">
                    <Column
                        field="guid"
                        :sortable="true"
                        header="Guid"
                        class="guidColumn tabletColumn"
                    />
                    <Column
                        field="title"
                        :sortable="true"
                        header="Title"
                        class="titleColumn"
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
                        class="categoryColumn desktopColumn"
                    />
                </DataTable>
            </template>
        </Card>
    </div>
</template>
