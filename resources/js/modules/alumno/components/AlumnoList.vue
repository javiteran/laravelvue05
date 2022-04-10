<template>
    <section id="alumno">
        <!-- filters -->
        <el-col
            :span="24"
            class="m-t-10"
        >
            <el-form
                :inline="true"
                :model="filters"
                size="mini"
                @submit.native.prevent="fetchData"
            >
                <el-form-item>
                    <el-button
                        type="primary"
                        icon="el-icon-plus"
                        @click="handleAdd"
                    >
                        {{ $t('global.add') }}
                    </el-button>
                </el-form-item>
                <el-form-item class="mr-0 float-right">
                    <el-input
                        v-model="filters.search"
                        :placeholder="$t('global.search')"
                        @input="applySearch"
                    >
                        <i
                            v-if="filters.search.length"
                            slot="suffix"
                            class="el-input__icon el-icon-error"
                            @click="clearSearch"
                        />
                    </el-input>
                </el-form-item>
            </el-form>
        </el-col>

        <!-- table -->
        <el-table
            v-loading="alumnosLoading"
            :data="alumnos"
            highlight-current-row
            class="w-100"
            @sort-change="handleSortChange"
            @filter-change="handleFilterChange"
        >
            <el-table-column
                prop="id"
                label="Id"
                width="80"
            />
            <el-table-column
                prop="name"
                label="Name"
                min-width="200"
                sortable
            >
                <template slot-scope="scope">
                    <router-link
                        :to="{name: 'Show Alumno', params: {id: scope.row.id}}"
                        class="el-link el-link--default ellipsis-form"
                    >
                        <span class="el-link--inner item_name">
                            {{ scope.row.name }}
                        </span>
                    </router-link>
                </template>
            </el-table-column>

            <el-table-column
                prop="curso"
                label="Curso"
                min-width="200"
                sortable
            >
                <template slot-scope="scope">
                    <router-link
                        :to="{name: 'Show Alumno', params: {id: scope.row.id}}"
                        class="el-link el-link--default ellipsis-form"
                    >
                        <span class="el-link--inner item_name">
                            {{ scope.row.curso }}
                        </span>
                    </router-link>
                </template>
            </el-table-column>

            <el-table-column
                :sort-orders="sortOrders"
                sortable
                prop="created_at"
                label="Created"
                width="200"
            >
                <template slot-scope="created_at">
                    {{ (created_at.row.created_at) }}
                </template>
            </el-table-column>
            <el-table-column
                :sort-orders="sortOrders"
                sortable
                prop="updated_at"
                label="Updated"
                width="200"
            >
                <template slot-scope="updated_at">
                    {{ (updated_at.row.updated_at) }}
                </template>
            </el-table-column>
            <el-table-column
                label="Actions"
                width="130"
                align="right"
            >
                <template slot-scope="scope">
                    <el-tooltip
                        :open-delay="300"
                        :content="$t('global.edit')"
                        placement="top"
                    >
                        <span>
                            <el-button
                                size="mini"
                                icon="el-icon-edit"
                                @click="handleEdit(scope.row)"
                            />
                        </span>
                    </el-tooltip>
                    <el-tooltip
                        :open-delay="300"
                        :content="$t('global.delete')"
                        placement="top"
                    >
                        <span>
                            <el-button
                                type="danger"
                                size="mini"
                                icon="el-icon-delete"
                                @click="handleDelete(scope.row)"
                            />
                        </span>
                    </el-tooltip>
                </template>
            </el-table-column>
        </el-table>

        <!-- pagination -->
        <el-pagination
            :current-page.sync="page"
            :page-size.sync="globalPageSize"
            :total="alumnosMeta.total"
            layout="sizes, prev, pager, next"
            class="float-right mt-3 mb-3"
        />

        <!-- form dialog -->
        <el-dialog
            :title="formTitle"
            :visible.sync="formVisible"
            close-on-click-modal
            class="alumnos-dialog"
        >
            <AlumnoForm
                :initial-form="formData"
                @saved="saved"
                @cancel="formVisible = false"
            />
        </el-dialog>
    </section>
</template>

<script>
import {mapActions, mapGetters, mapMutations} from 'vuex'
import {ALUMNO_FETCH, ALUMNO_OBTAIN} from '../store/types'
import alumnoApi from '../api'
import AlumnoForm from './AlumnoForm'

export default {
    name:'AlumnoList',
    components: {AlumnoForm},
    data() {
        return {
            sortBy: 'id,asc',
            sortOrders: ['ascending', 'descending'],
            filters: {
                search: ''
            },
            page: 1,
            formVisible: false,
            formTitle: 'New Alumno',
            formData: null
        }
    },
    computed: {
        ...mapGetters(['alumnos', 'alumnosMeta', 'alumnosLoading']),
    },
    created() {
        this.fetchData()
    },
    watch:{
        page: function () {
            this.fetchData()
        },
        pageSize: function () {
            this.fetchData()
        },
    },
    methods: {
        ...mapActions([ALUMNO_FETCH]),
        ...mapMutations([ALUMNO_OBTAIN]),
        handleSortChange(val) {
            if (val.prop != null && val.order != null) {
                let sort = val.order.startsWith('a') ? 'asc' : 'desc'
                this.sortBy = val.prop + ',' + sort
                this.fetchData()
            }
        },
        handleFilterChange() {
            this.fetchData()
        },
        fetchData() {
            let params = {
                page: this.page,
                search: this.filters.search,
                sortBy: this.sortBy,
                pageSize: this.globalPageSize
            }
            this[ALUMNO_FETCH](params)
        },
        handleAdd() {
            this.formTitle = 'New Alumno'
            this.formData = {}
            this.formVisible = true
        },
        handleEdit(row) {
            this.formTitle = 'Edit Alumno'
            this.formData = Object.assign({}, row)
            this.formVisible = true
        },
        handleDelete(row) {
            this.$confirm('This will permanently delete the alumno. Continue?', 'Warning', {
                type: 'warning'
            }).then(() => {
                alumnoApi.delete(row.id).then((response) => {
                    this.$message({
                        message: response.data.message,
                        type: response.data.type
                    })
                    this.fetchData()
                })
            })
        },
        applySearch: _.debounce( function() {
            this.fetchData()
        }, 300),
        clearSearch() {
            this.filters.search = ''
            this.fetchData()
        },
        saved() {
            this.formVisible = false
            this.fetchData()
        },
    },
}
</script>
