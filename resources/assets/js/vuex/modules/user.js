import * as types from '../mutation-types';

const state = {
  id: null,
  name: '',
  email: '',
  role: ''
};

const mutations = {
  [types.SET_AUTH_USER] (state, user) {
    state.id = user.id;
    state.name = user.name;
    state.email = user.email;
    state.role = user.role
  }
};

export default {
  state,
  mutations
};
