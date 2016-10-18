<template>
  <div class="product-item">
    <a class="back-link" v-link="{path:'/'}">&lt; BACK</a>
    <div class="product-title">{{ product.title }}</div>
    <div class="product-details">
      <div class="inventory">In Stock: {{ product.inventory }}</div>
      <button class="add-button" :disabled="!product.inventory"
        @click="addToCart(product)">{{ product.inventory > 0 ? "Add to cart" : "Out Of Stock" }}</button>
    </div>
  </div>
</template>

<script>
  import { getAllProducts, addToCart } from '../vuex/products/actions'
  export default {
    vuex: {
      getters: {
        product: ({products, route}) => {
          var id = parseInt(route.params.id)
          return products.all.find((p) => p.id === id) || {}
        }
      },
      actions: {
        getAllProducts,
        addToCart
      }
    },
    created () {
      this.getAllProducts()
    }
  }
</script>

<style>
.product-item {
  margin: 10px 10px;
  width: 500px;
  height: 400px;
  border-bottom: 1px solid #aaa;
}

.back-link {
  font-size: 20px;
}

.product-title {
  padding-top: 120px;
  text-align: center;
  margin: 0 auto;
  font-size: 26px;
}

.product-details {
  margin-top: 120px;
}

.inventory {
  float: left;
  font-size: 20px;
  margin-top: 15px;
}
.add-button {
  float: right;
  width: 140px;
  height: 50px;
}
</style>
