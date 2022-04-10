import * as types from './types'
import {actions} from './actions'

export const store = {
    state: {
        alumnos: [],
        alumnosMeta: [],
        alumnosLoading: true,
    },
    getters: {
        alumnos: state => state.alumnos,
        alumnosMeta: state => state.alumnosMeta,
        alumnosLoading: state => state.alumnosLoading,
    },
    mutations: {
        [types.ALUMNO_OBTAIN](state, alumnos) {
            state.alumnos = alumnos
        },
        [types.ALUMNO_CLEAR](state) {
            state.alumnos = []
        },
        [types.ALUMNO_SET_LOADING](state, loading) {
            state.alumnosLoading = loading
        },
        [types.ALUMNO_META](state, meta) {
            state.alumnosMeta = meta
        },
    },
    actions
}
