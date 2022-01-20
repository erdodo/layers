import { createStore } from 'vuex'

export default createStore({
  state: {
    updatePropData: {
      name:'',
      type:'',
      propertyContent:{
        content:''
      }
    },
  },
  mutations: {
    setUpdatePropData(state, updatePropData) {
      if(updatePropData.propertyContent==null){
        updatePropData.propertyContent={
          content:null,
          id:null
        }
      }
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
