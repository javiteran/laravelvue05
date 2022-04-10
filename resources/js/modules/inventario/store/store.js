import * as types from './types'
import {actions} from './actions'

export const store = {
    state: {
        inventarios: [],
        inventariosMeta: [],
        inventariosLoading: true,
    },
    getters: {
        inventarios: state => state.inventarios,
        inventariosMeta: state => state.inventariosMeta,
        inventariosLoading: state => state.inventariosLoading,
    },
    mutations: {
        [types.INVENTARIO_OBTAIN](state, inventarios) {
            state.inventarios = inventarios
        },
        [types.INVENTARIO_CLEAR](state) {
            state.inventarios = []
        },
        [types.INVENTARIO_SET_LOADING](state, loading) {
            state.inventariosLoading = loading
        },
        [types.INVENTARIO_META](state, meta) {
            state.inventariosMeta = meta
        },
    },
    actions
}
