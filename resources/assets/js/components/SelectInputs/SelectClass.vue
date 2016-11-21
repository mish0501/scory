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

      if(this.$parent.subject){
        this.$parent.subject = null
      }

      this.$http.post("/api/selectSubjects", { class: this.classes }).then((response) => {
        this.$store.dispatch('set_class', this.classes);
        this.$store.dispatch('set_subjects', response.data);

        if(this.$parent.subject == null){
          this.$parent.subject = 0
        }

        if(this.$parent.title){
          this.$parent.title = "Избери си предмет"
        }

      }, (err) => {
        console.log(err);
      })
    }
  }
}
</script>
