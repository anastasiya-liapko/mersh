import categories from '@/data/categories.js'

const state = {
  categories: categories
}

const mutations = {}

const actions = {}

const getters = {
  categories: state => {
    return state.categories
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
