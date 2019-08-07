import Vue from 'vue'
import Vuex from 'vuex'
import navHeader from '@/store/modules/navHeader'
import navFooter from '@/store/modules/navFooter'
import categories from '@/store/modules/categories'
import products from '@/store/modules/products'
import popup from '@/store/modules/popup'
import select from '@/store/modules/select'
import papers from '@/store/modules/papers'
import cart from '@/store/modules/cart'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {

  },
  mutations: {

  },
  actions: {

  },
  modules: {
    navHeader,
    navFooter,
    categories,
    products,
    popup,
    select,
    papers,
    cart
  }
})
