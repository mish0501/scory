import * as types from '../mutation-types';

const state = {
  id: null,
  name: '',
  email: '',
  role: '',
  permissions: []
};

const mutations = {
  [types.SET_AUTH_USER] (state, user) {
    state.id = user.id;
    state.name = user.name;
    state.email = user.email;
    state.role = user.role;
    state.permissions = user.permissions
  },

  [types.RESET_AUTH_USER] (state) {
    state.id = null;
    state.name = '';
    state.email = '';
    state.role = '';
    state.permissions = []
  }
};

export default {
  state,
  mutations
};
