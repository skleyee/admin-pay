import { createStore } from 'vuex'

export default createStore({
  state: {
    authToken: null
  },
  getters: {
    authToken: (state) => state.authToken,
  },
  mutations: {
    setAuthToken(state, token) {
      state.authToken = token;
    },
    clearAuthToken(state) {
      state.authToken = null;
    },
  },
  actions: {
    saveAuthToken({ commit }, token) {
      commit('setAuthToken', token);
    },
    removeAuthToken({ commit }) {
      commit('clearAuthToken');
    },
  },
  modules: {
  }
})
