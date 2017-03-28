import * as types from './mutation-types.js'

export const set_questions = ({ commit }, data) => {
  commit(types.SET_QUESTIONS, data)
}
export const set_subjects = ({ commit }, data) => {
  commit(types.SET_SUBJECTS, data)
}
export const set_partitions = ({ commit }, data) => {
  commit(types.SET_PARTITIONS, data)
}
export const set_class = ({ commit }, data) => {
  commit(types.SET_CLASS, data)
}

export const reset_test = ({ commit }) => {
  commit(types.RESET_TEST)
}

export const set_user = ({commit}, data) => {
  commit(types.SET_AUTH_USER, data)
}

export const set_lessons = ({ commit }, data) => {
  commit(types.SET_LESSONS, data)
}

export const clear_store = ({ commit }) => {
  commit(types.RESET_TEST)
  commit(types.RESET_AUTH_USER)
  commit(types.RESET_LESSONS)
}
