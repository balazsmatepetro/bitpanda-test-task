import Vue from 'vue';
import Vuex from 'vuex';
import { currencyList } from './stores/CurrencyList';
import { currencyModal } from './stores/CurrencyModal';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    currencyList,
    currencyModal,
  },
});
