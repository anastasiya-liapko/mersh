const state = {
  cartProducts: [],
  totalPrice: 0,
  totalQuantity: 0,
  disabled: false,
  order: '',
  deliveryPrice: 0,
  orderNumber: ''
}

const mutations = {
  'ADD_TO_CART' (state, item) {
    const record = state.cartProducts.find(element => element.id === item.id && element.variant === item.variant)
    if (record) {
      record.quantity += item.quantity
      record.total = +(record.total + item.price * item.quantity).toFixed(10)
    } else {
      item.total = +(item.price * item.quantity).toFixed(10)
      item.index = state.cartProducts.length
      state.cartProducts.push(item)
    }
    state.totalPrice = +(state.totalPrice + item.price * item.quantity).toFixed(10)
    state.totalQuantity += item.quantity
  },
  'REMOVE_FROM_CART' (state, item) {
    const record = state.cartProducts.find(element => element.id === item.id && element.variant === item.variant)
    state.cartProducts.splice(state.cartProducts.indexOf(record), 1)
    state.cartProducts.forEach(function (elem, i) {
      elem.index = i
    })
    state.totalPrice = +(state.totalPrice - item.price * item.quantity).toFixed(10)
    state.totalQuantity -= item.quantity
  },
  'UPDATE_QUANTITY' (state, item) {
    const record = state.cartProducts.find(element => element.id === item.id && element.index === item.index)
    const change = item.quantity - record.quantity
    if (parseInt(item.quantity) === 0) {
      state.cartProducts.splice(state.cartProducts.indexOf(record), 1)
      state.cartProducts.forEach(function (elem, i) {
        elem.index = i
      })
    } else {
      record.quantity = item.quantity
      record.total = +(record.price * item.quantity).toFixed(10)
    }
    state.totalPrice = +(state.totalPrice + item.price * change).toFixed(10)
    state.totalQuantity += change
  },
  'UPDATE_VARIANT' (state, item) {
    const record = state.cartProducts.find(element => element.id === item.id && element.index === item.index)
    if (record) {
      record.variant = item.variant
      record.total = +(record.price * item.quantity).toFixed(10)
    }
    state.totalPrice = 0
    state.cartProducts.forEach(function (elem) {
      state.totalPrice += elem.total
    })
    item.variant === '' ? state.disabled = true : state.disabled = false
  },
  'ADD_DELIVERY' (state, delivery) {
    const change = delivery.price - state.deliveryPrice
    state.deliveryPrice = delivery.price
    state.totalPrice = +(state.totalPrice + change).toFixed(10)
  },
  'SAVE_TO_STORAGE' (state) {
    localStorage.setItem('mershProducts', JSON.stringify(state.cartProducts))
    localStorage.setItem('mershTotalPrice', JSON.stringify(state.totalPrice))
    localStorage.setItem('mershTotalQuantity', JSON.stringify(state.totalQuantity))
  },
  'EMPTY_CART' (state) {
    state.cartProducts = []
    state.totalPrice = 0
    state.totalQuantity = 0
    state.order = []
    state.orderNumber = ''
    state.disabled = false
  },
  'CHECK_IF_VALID' (state) {
    state.cartProducts.forEach(function (elem) {
      // if (elem.variant === '' && elem.variants !== undefined) {
      //   state.disabled = true
      // }
    })
  },
  'SET_ORDER' (state, order) {
    state.order = order
    localStorage.setItem('mershOrder', JSON.stringify(state.order))
  },
  'SET_ORDER_NUMBER' (state, number) {
    state.orderNumber = number
    localStorage.setItem('mershOrderNumber', JSON.stringify(state.orderNumber))
  }
}

const actions = {
  addToCart: ({ commit }, item) => {
    commit('ADD_TO_CART', item)
    commit('SAVE_TO_STORAGE')
  },
  removeFromCart: ({ commit }, item) => {
    commit('REMOVE_FROM_CART', item)
    commit('SAVE_TO_STORAGE')
  },
  updateQuantity: ({ commit }, item) => {
    commit('UPDATE_QUANTITY', item)
    commit('SAVE_TO_STORAGE')
  },
  updateVariant: ({ commit }, item) => {
    commit('UPDATE_VARIANT', item)
    commit('SAVE_TO_STORAGE')
  },
  addDelivery: ({ commit }, delivery) => {
    commit('ADD_DELIVERY', delivery)
    commit('SAVE_TO_STORAGE')
  },
  emptyCart: ({ commit }) => {
    commit('EMPTY_CART')
  },
  checkIfValid: ({ commit }) => {
    commit('CHECK_IF_VALID')
  },
  setOrder: ({ commit }, order) => {
    commit('SET_ORDER', order)
  },
  setOrderNumber: ({ commit }, number) => {
    commit('SET_ORDER_NUMBER', number)
  }
}

const getters = {
  cartProducts: state => {
    return state.cartProducts
  },
  totalPrice: state => {
    return state.totalPrice
  },
  totalQuantity: state => {
    return state.totalQuantity
  },
  disabled: state => {
    return state.disabled
  },
  order: state => {
    return state.order
  },
  orderNumber: state => {
    return state.orderNumber
  }
}

export default {
  state,
  mutations,
  actions,
  getters
}
