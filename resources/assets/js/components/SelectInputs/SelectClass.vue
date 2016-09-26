<template lang="html">
  <select class="form-control" name="class" v-model="class" v-on:change="ClassSelected">
    <option selected disabled >Избери си клас</option>
    <option name='class' value="{{ n + 5 }}" v-for="n in 8">{{n + 5}}. Клас</option>
  </select>
</template>

<script>
export default {
  data () {
    return {
      class: null
    }
  },

  methods: {
    ClassSelected: function() {
      this.$http.post("/chooseSubject", { class: this.class}).then((response) => {
        this.$dispatch('classSelected', { class: this.class, subjects: response.data })
      }, (err) => {
        console.log(err);
      })
    }
  }
}
</script>
