/**
 * YOU CAN SAFELY REMOVE THIS FILE.
 * FILE FOR DEMO PURPOSE ONLY
 *
 * Notes:
 *
 * This file contains 'getters' for the cart, which are functions which
 * take a whole state and transforms it into data we're interested in
 */

// The cartProducts function return all the products in our cart
// but also looks up the title and price, since we only store the IDs
// in the cart
export const cartProducts = state => {
  return state.cart.added.map(({ id, quantity }) => {
    const product = state.products.all.find(p => p.id === id)
    return {
      title: product.title,
      price: product.price,
      quantity
    }
  })
}

// This creates a total sum of all the items in the cart. This is an example
// of how a getter can return a scalar value which can be re-used in views
export const cartCount = state => {
  var totalCount = 0
  state.cart.added.forEach(({ quantity }) => {
    totalCount += quantity
  })

  return totalCount
}
