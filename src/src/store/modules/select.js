import selects from '@/data/selects'

const state = {
  name: '',
  show: false,
  delivery: selects.delivery,
  payment: selects.payment
}

const mutations = {
  'TOGGLE_SELECT' (state, { name, show }) {
    state.name = name
    state.show = !show
  },
  'HIDE_SELECT' (state, name) {
    state.name = name
    state.show = false
  },
  'RESET_SELECT' (state, { name }) {
    state.delivery = selects.delivery
    state.payment = selects.payment
  }
}

const actions = {
  toggleSelect ({ commit }, value) {
    commit('TOGGLE_SELECT', value)
  },
  hideSelect ({ commit }, value) {
    commit('HIDE_SELECT', value)
  },
  resetSelect ({ commit }, value) {
    commit('RESET_SELECT', value)
  }
}

const getters = {
  selectDelivery: state => {
    return state.delivery
  },
  selectPayment: state => {
    return state.payment
  },
  selectName: state => {
    return state.name
  },
  selectShow: state => {
    return state.show
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
