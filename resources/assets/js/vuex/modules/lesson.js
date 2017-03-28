import * as types from '../mutation-types';

const state = {
  lessons: []
}

const mutations = {
  [types.SET_LESSONS] (state, lessons) {
    state.lessons = lessons
  },
  [types.RESET_LESSONS] (state) {
    state.lessons = []
  }
}

export default {
  state,
  mutations
}
