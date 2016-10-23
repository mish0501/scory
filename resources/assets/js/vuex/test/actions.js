import * as types from '../mutation-types'

export const set_questions = ({ dispatch, state }, data) => {
  dispatch(types.SET_QUESTIONS, data)
}
export const set_subjects = ({ dispatch, state }, data) => {
  dispatch(types.SET_SUBJECTS, data)
}
export const set_partitions = ({ dispatch, state }, data) => {
  dispatch(types.SET_PARTITIONS, data)
}
export const set_class = ({ dispatch, state }, data) => {
  dispatch(types.SET_CLASS, data.class)
  dispatch(types.SET_SUBJECTS, data.subjects)
  dispatch(types.SET_PARTITIONS, [])
}
