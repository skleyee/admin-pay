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
      localStorage.setItem('authToken', token);
      commit('setAuthToken', token);
    },
    loadToken({ commit }) {
      const token = localStorage.getItem('authToken');
      if (token) {
        commit('setAuthToken', token);
      }
    },
    removeAuthToken({ commit }) {
      localStorage.removeItem('authToken');
      commit('clearAuthToken');
    },
  },
  modules: {
  }
})
