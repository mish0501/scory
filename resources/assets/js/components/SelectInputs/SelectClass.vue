<template lang="html">
  <select class="form-control" name="class" v-model="classes" v-on:change="ClassSelected">
    <option disabled value="0">Избери си клас</option>
    <option name='class' v-bind:value="n + 4" v-for="n in 8">{{n + 4}}. Клас</option>
    {{getClass}}
  </select>
</template>

<script>
export default {
  data() {
    return {
      classes: 0
    }
  },

  computed: {
    getClass(){
      this.classes = this.$store.getters.Class
      return null
    }
  },

  methods: {
    ClassSelected: function() {
      this.$parent.isLoading = true
      this.$http.post("/api/selectSubjects", { class: this.classes }).then((response) => {
        this.$store.dispatch('set_class', this.classes);
        this.$store.dispatch('set_subjects', response.data);

        this.$emit('classSelected', {
          subject: 0,
          partition: null,
          title: "Избери си предмет"
        })

        this.$parent.isLoading = false
      }, (err) => {
        console.log(err);
      })
    }
  }
}
</script>
