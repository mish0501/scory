import {
  SET_QUESTIONS,
  SET_SUBJECTS,
  SET_PARTITIONS,
  SET_CLASS,
} from '../mutation-types'

const state = {
  questions: [],
  subjects: [],
  partitions: [],
  class: null
}

const mutations = {
  [SET_QUESTIONS] (state, questions) {
    state.questions = questions
  },

  [SET_SUBJECTS] (state, subjects) {
    state.subjects = subjects
  },

  [SET_PARTITIONS] (state, partitions) {
    state.partitions = partitions
  },

  [SET_CLASS] (state, selectedClass) {
    state.class = selectedClass
  }
}

export default {
  state,
  mutations
}
