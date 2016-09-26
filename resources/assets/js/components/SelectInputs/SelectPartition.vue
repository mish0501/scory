<template>
  <select class="form-control" v-model="partition" v-on:change="PartitionSelected">
    <option selected disabled value="default">Избери си раздел</option>
    <option value="{{ partition.id }}" v-for="partition in partitions">{{ partition.name }}</option>
  </select>
</template>

<script>
export default {
  props: {
    partitions: {
      required: true
    },
    partition: {
      required: true
    }
  },

  methods: {
    PartitionSelected: function() {
      this.$dispatch('partitionSelected', { partition: this.partition })
    }
  }
}
</script>
