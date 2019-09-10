import papers from '@/data/papers.js'

const state = {
  papers: papers
}

const mutations = {}

const actions = {}

const getters = {
  papers: state => {
    return state.papers
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
