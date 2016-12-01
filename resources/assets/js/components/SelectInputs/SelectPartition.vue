<template>
  <select class="form-control" v-model="partition" v-on:change="PartitionSelected">
    <option disabled value="0">Избери си раздел</option>
    <option v-bind:value="partition.id" v-for="partition in partitions">{{ partition.name }}</option>
  </select>
</template>

<script>


export default {
  props: {
    partitionId: {
      required: true
    }
  },

  data() {
    return{
      partition: this.partitionId
    }
  },

  watch: {
    partitionId (newPartitionId) {
      this.partition = newPartitionId
    }
  },

  computed: {
    partitions() {
      return this.$store.getters.Partitions
    }
  },

  methods: {
    PartitionSelected() {
      this.$emit('partitionSelected', {
        partition: this.partition,
        questionCount: 0,
        title: "Избери си броя на въпросите"
      })
    }
  }
}
</script>
