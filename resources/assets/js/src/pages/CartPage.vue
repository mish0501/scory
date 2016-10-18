<template>
  <div class="cart">
    <p v-show="!products.length"><i>Please add some products to cart.</i></p>
    <div v-show="products.length > 0">
    <table class="checkout-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Quantity</th>
          <th>Per Unit</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
      <tr v-for="p in products">
        <td><a v-link="{name:'product', params:{id:p.id}}">{{ p.title }}</a></td>
        <td>{{ p.price|currency }}</td>
        <td>{{ p.quantity }}</td>
        <td>{{ p.price * p.quantity | currency }}</td>
      </tr>
      <tr class='total'>
        <td><b>TOTAL</b></td>
        <td></td>
        <td></td>
        <td>{{ total|currency }}</td>
      </tr>
      </tbody>
    </table>
    <p><button :disabled="!products.length" @click="checkout(products)" class='checkout-button'>Checkout</button></p>
    <p v-show="checkoutStatus">Checkout {{ checkoutStatus }}.</p>
    </div>
  </div>
</template>

<script>
  import { checkout } from '../vuex/cart/actions'
  import { cartProducts } from '../vuex/cart/getters'

  export default {
    vuex: {
      getters: {
        products: cartProducts,
        checkoutStatus: ({ cart }) => cart.lastCheckout
      },
      actions: {
        checkout
      }
    },
    computed: {
      total () {
        return this.products.reduce((total, p) => {
          return total + p.price * p.quantity
        }, 0)
      }
    }
  }
</script>

<style>

.cart {
  width: 600px;
}
.checkout-table {
  width: 100%;
}

.checkout-table th {
  text-align: left;
  padding: 15px 0px;
  border-bottom: 1px solid #aaa;
}

.checkout-table td {
  padding: 8px 0px;
}

.checkout-button {
  float: right;
  width: 120px;
  height: 40px;
  margin-top: 20px;
}

.total td {
  border-top: 1px solid #aaa;
  padding-top: 10px;
}
</style>
