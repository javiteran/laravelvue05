import * as types from './types'
import {actions} from './actions'

export const store = {
    state: {
        productos: [],
        productosMeta: [],
        productosLoading: true,
    },
    getters: {
        productos: state => state.productos,
        productosMeta: state => state.productosMeta,
        productosLoading: state => state.productosLoading,
    },
    mutations: {
        [types.PRODUCTO_OBTAIN](state, productos) {
            state.productos = productos
        },
        [types.PRODUCTO_CLEAR](state) {
            state.productos = []
        },
        [types.PRODUCTO_SET_LOADING](state, loading) {
            state.productosLoading = loading
        },
        [types.PRODUCTO_META](state, meta) {
            state.productosMeta = meta
        },
    },
    actions
}
