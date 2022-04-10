import * as types from './types'
import productoApi from '../api'

export const actions = {
    async [types.PRODUCTO_FETCH]({commit}, data = null) {
        commit(types.PRODUCTO_SET_LOADING, true)
        const response = await productoApi.all(data)
        commit(types.PRODUCTO_OBTAIN, response.data.data)
        commit(types.PRODUCTO_META, response.data.meta)
        commit(types.PRODUCTO_SET_LOADING, false)
    },
}
