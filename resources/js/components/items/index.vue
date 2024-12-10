<template>
    <vue-good-table
        mode="remote"
        @on-page-change="onPageChange"
        @on-sort-change="onSortChange"
        @on-column-filter="onColumnFilter"
        @on-per-page-change="onPerPageChange"
        :totalRows="totalRecords"
        :pagination-options="{
            enabled: true,
        }"
        :columns="columns"
        :rows="rows">

        <template slot="table-row" slot-scope="props">
            <span v-if="props.column.field == 'actions'">
                <a class="btn btn-sm btn-primary" @click="updateItem(props.formattedRow['id'])">ыфв</a>
                <a class="btn btn-sm btn-danger" @click="deleteItem(props.formattedRow['id'], props.row.originalIndex)">Удалить</a>
            </span>
            <span v-else>
                {{ props.formattedRow[props.column.field] }}
            </span>
        </template>
    </vue-good-table>
</template>

<script>
    export default {
        props: {
            url: {
                required: true,
                type: String
            },
            entity: {
                required: true,
                type: String
            }
        },
        data() {
            return {
                totalRecords: 0,

                serverParams: {
                    columnFilters: {
                    },
                    sort: {
                        field: 'created_at',
                        type: 'asc',
                    },
                    page: 1,
                    perPage: 10
                },

                columns: [],
                rows: [],
            }
        },
        mounted() {
            //
        },
        created() {
            this.loadItems();
        },
        methods: {

            updateItem(id) {
                window.location.href = './' + this.entity + '/' + id;
            },

            async deleteItem(id, index) {
                if(!confirm('Вы уверены, что хотите удалить данную запись?')) {
                    return;
                }
                const response = await axios.post(
                    './' + this.entity + '/delete/' + id);
                this.rows.splice(index, 1);
            },

            updateParams(newProps) {
                this.serverParams = {...this.serverParams, ...newProps};
            },

            onPageChange(params) {
                this.updateParams({page: params.currentPage});
                this.loadItems();
            },

            onPerPageChange(params) {
                this.updateParams({perPage: params.currentPerPage});
                this.loadItems();
            },

            onSortChange(params) {
                this.updateParams({
                    sort: params[0],
                });
                this.loadItems();
            },

            onColumnFilter(params) {
                this.updateParams(params);
                this.loadItems();
            },

            async loadItems() {
                try {
                    const params = {
                        limit: this.serverParams.perPage
                    };

                    if(this.serverParams.sort.field && this.serverParams.sort.type !== 'none') {
                        params.orderBy = this.serverParams.sort.field;
                        params.sortedBy = this.serverParams.sort.type;
                        params.page = this.serverParams.page;
                    }

                    const response = await axios.get(this.url, {
                        params
                    });

                    this.rows = response.data.items;
                    this.totalRecords = response.data.meta.total;
                    this.columns = response.data.columns;
                } catch (_) {}
            }
        }
    }
</script>
