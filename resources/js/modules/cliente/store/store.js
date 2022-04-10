import * as types from './types'
import {actions} from './actions'

export const store = {
    state: {
        clientes: [],
        clientesMeta: [],
        clientesLoading: true,
    },
    getters: {
        clientes: state => state.clientes,
        clientesMeta: state => state.clientesMeta,
        clientesLoading: state => state.clientesLoading,
    },
    mutations: {
        [types.CLIENTE_OBTAIN](state, clientes) {
            state.clientes = clientes
        },
        [types.CLIENTE_CLEAR](state) {
            state.clientes = []
        },
        [types.CLIENTE_SET_LOADING](state, loading) {
            state.clientesLoading = loading
        },
        [types.CLIENTE_META](state, meta) {
            state.clientesMeta = meta
        },
    },
    actions
}
