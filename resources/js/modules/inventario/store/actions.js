import * as types from './types'
import inventarioApi from '../api'

export const actions = {
    async [types.INVENTARIO_FETCH]({commit}, data = null) {
        commit(types.INVENTARIO_SET_LOADING, true)
        const response = await inventarioApi.all(data)
        commit(types.INVENTARIO_OBTAIN, response.data.data)
        commit(types.INVENTARIO_META, response.data.meta)
        commit(types.INVENTARIO_SET_LOADING, false)
    },
}
