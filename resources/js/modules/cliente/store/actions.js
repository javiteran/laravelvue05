import * as types from './types'
import clienteApi from '../api'

export const actions = {
    async [types.CLIENTE_FETCH]({commit}, data = null) {
        commit(types.CLIENTE_SET_LOADING, true)
        const response = await clienteApi.all(data)
        commit(types.CLIENTE_OBTAIN, response.data.data)
        commit(types.CLIENTE_META, response.data.meta)
        commit(types.CLIENTE_SET_LOADING, false)
    },
}
