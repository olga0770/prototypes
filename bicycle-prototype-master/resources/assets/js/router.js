import Vue from 'vue';
import axios from 'axios';
import store from './store';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import BikePage from '../components/BikePage.vue';
import BikeDetailPage from '../components/BikeDetailPage.vue';

let router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/', component: BikePage, name: 'bike' },
    { path: '/bikes/:bike_id', component: BikeDetailPage , name: 'bikedetail' },
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});

router.beforeEach((to, from, next) => {
  let serverData = JSON.parse(window.bike_server_data);
  if (
    to.name === 'bike'
      ? store.getters.getBike(to.params.bike)
      : store.state.bike_summaries.length > 0
  ) {
    next();
  }
  else if (
      to.name === 'bikedetail'
          ? store.getters.getBike(to.params.bike)
          : store.state.bike_summaries.length > 0
  ) {
    next();
  }
  else if (!serverData.path || to.path !== serverData.path) {
    axios.get(`/api${to.path}`).then(({data}) => {
      store.commit('addData', {route: to.name, data});
      next();
    });
  }
  else {
    store.commit('addData', {route: to.name, data: serverData});
    next();
  }
});

export default router;
