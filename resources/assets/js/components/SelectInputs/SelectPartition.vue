<template>
  <select class="form-control" v-model="partition">
    <option selected disabled value="default">Избери си раздел</option>
    <option value="{{ partition.id }}" v-for="partition in partitions">{{ partition.name }}</option>
  </select>
</template>

<script>

import { Partitions } from "../../vuex/test/getters.js"

export default {
  props: {
    partition: {
      required: true
    }
  },

  vuex: {
    getters: {
      partitions: Partitions
    }
  }
}
</script>
