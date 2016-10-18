/**
 * YOU CAN SAFELY REMOVE THIS FILE.
 * FILE FOR DEMO PURPOSE ONLY
 *
 * Notes:
 *
 * This file contains the store for the cart. The store contains two parts:
 *
 * 1. The initial state: Which defines the state object when it's just created
 * 2. Logic on how to apply "mutations". A mutation is simply a clear "atomic" change
 *    which has a clear and single purpose of modifying the state in a particular way
 */

// What kind of mutations are we handling? import them so any
// typing mistakes are caught easily by the compiler.
import {
  ADD_TO_CART,
  CHECKOUT_REQUEST,
  CHECKOUT_SUCCESS,
  CHECKOUT_FAILURE
} from '../mutation-types'

// shape: [{ id, quantity }]
const state = {
  added: [],
  lastCheckout: null
}

// mutations
const mutations = {
  [ADD_TO_CART] (state, productId) {
    state.lastCheckout = null
    const record = state.added.find(p => p.id === productId)
    if (!record) {
      state.added.push({
        id: productId,
        quantity: 1
      })
    } else {
      record.quantity++
    }
  },

  [CHECKOUT_REQUEST] (state) {
    // clear cart
    state.added = []
    state.lastCheckout = null
  },

  [CHECKOUT_SUCCESS] (state) {
    state.lastCheckout = 'successful'
  },

  [CHECKOUT_FAILURE] (state, savedCartItems) {
    // rollback to the cart saved before sending the request
    state.added = savedCartItems
    state.lastCheckout = 'failed'
  }
}

export default {
  state,
  mutations
}
