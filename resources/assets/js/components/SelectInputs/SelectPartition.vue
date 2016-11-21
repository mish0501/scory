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

  computed: {
    partitions() {
      return this.$store.getters.Partitions
    }
  },

  methods: {
    PartitionSelected() {
      this.$parent.partition = this.partition
      this.$parent.questionCount = 0

      if(this.$parent.title){
        this.$parent.title = "Избери си броя на въпросите"
      }
    }
  }
}
</script>
