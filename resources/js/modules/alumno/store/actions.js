import * as types from './types'
import alumnoApi from '../api'

export const actions = {
    async [types.ALUMNO_FETCH]({commit}, data = null) {
        commit(types.ALUMNO_SET_LOADING, true)
        const response = await alumnoApi.all(data)
        commit(types.ALUMNO_OBTAIN, response.data.data)
        commit(types.ALUMNO_META, response.data.meta)
        commit(types.ALUMNO_SET_LOADING, false)
    },
}
