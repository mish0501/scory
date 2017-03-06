import * as types from '../mutation-types';

const state = {
  lessons: []
}

const mutations = {
  [types.SET_LESSONS] (state, lessons) {
    state.lessons = lessons
  }
}

export default {
  state,
  mutations
}
