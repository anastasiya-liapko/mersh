const state = {
  id: '',
  show: false
}

const mutations = {
  'SWITCH_SHOW_POPUP' (state, id) {
    // if (state.id === id) {
    state.show = !state.show
    state.id = id
    // } else {
    //   state.show = false
    //   setTimeout(function () {
    //     state.id = id
    //     state.show = true
    //   }, 500)
    // }

    setTimeout(function () {
      if (state.show) {
        document.querySelector('input').focus()
      }
    }, 200)
  },
  'HIDE_POPUP' (state, id) {
    // if (state.id === id) {
    state.show = false
    state.id = ''
    // }
  }
}

const actions = {
  switchShowPopup: ({ commit }, id) => {
    commit('SWITCH_SHOW_POPUP', id)
  },
  hidePopup: ({ commit }, id) => {
    commit('HIDE_POPUP', id)
  }
}

const getters = {
  showPopup: state => {
    return state.show
  },
  popupId: state => {
    return state.id
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
