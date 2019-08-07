import products from '@/data/products.js'

const state = {
  products: products
}

const mutations = {}

const actions = {}

const getters = {
  products: state => {
    return state.products
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
