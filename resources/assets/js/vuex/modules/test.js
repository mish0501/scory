import * as types from '../mutation-types';

const state = {
  questions: [],
  subjects: [],
  partitions: [],
  class: 0
}

const mutations = {
  [types.SET_QUESTIONS] (state, questions) {
    state.questions = questions
  },

  [types.SET_SUBJECTS] (state, subjects) {
    state.subjects = subjects
  },

  [types.SET_PARTITIONS] (state, partitions) {
    state.partitions = partitions
  },

  [types.SET_CLASS] (state, selectedClass) {
    state.class = selectedClass
  },

  [types.RESET_TEST] (state){
    state.questions = []
    state.subjects = []
    state.partitions = []
    state.class = 0
  }
}

export default {
  state,
  mutations
}
