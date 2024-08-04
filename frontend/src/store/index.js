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
      sessionStorage.setItem('authToken', token);
      commit('setAuthToken', token);
    },
    loadToken({ commit }) {
      const token = sessionStorage.getItem('authToken');
      if (token) {
        commit('setAuthToken', token);
      }
    },
    removeAuthToken({ commit }) {
      sessionStorage.removeItem('authToken');
      commit('clearAuthToken');
    },
  },
  modules: {
  }
})
