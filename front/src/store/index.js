import { createStore } from 'vuex'

export default createStore({
  state: {
    updatePropData: null,
  },
  mutations: {
    setUpdatePropData(state, updatePropData) {
      state.updatePropData = updatePropData
    }
  },
  actions: {
  },
  modules: {
  },
  getters: {
    getUpdatePropData: state => state.updatePropData
  }
})
