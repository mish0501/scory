<template>
    <div v-for="p in products" class="product">
      <a v-link="{name:'product', params:{id:p.id}}" class="title">{{ p.title }}</a>
      <span class="price">{{ p.price | currency }}</span>
    </div>
  </div>
</template>

<script>
  import { getAllProducts, addToCart } from '../vuex/products/actions'

  export default {
    vuex: {
      getters: {
        products: ({ products }) => products.all
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
.product {
  padding: 10px 0px;
  border-bottom: 1px solid #eee;
  width: 400px;
}

.title {
  color: #312377;
}

.price {
  float: right;
}
</style>
