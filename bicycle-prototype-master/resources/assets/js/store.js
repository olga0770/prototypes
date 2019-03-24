import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
Vue.config.devtools = true; // make the Vuex store available in the browser Dev Tools.

export default new Vuex.Store({
  state: {
    bike_summaries: [],
    bikes: [],
    bike_index: 0
  },
  mutations: {

    setBikeIndex(state, index) {
      state.bike_index = index;
    },

    addData(state, { route, data }) {
      if (route === 'bike') {
        state.bikes.push(data.bikes);
      }
      else if (route === 'bikedetail') {
        state.bikes.push(data.bikes);
        state.bike_index = data.bike_index;
      }
    }
  },
  getters: {
    getBike(state) {
      return id => state.bikes.find(bike => id == bike.id);
    }
  }
});
