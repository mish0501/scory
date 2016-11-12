<template lang="html">
  <select class="form-control" name="class" v-model="classes" v-on:change="ClassSelected">
    <option disabled value="0">Избери си клас</option>
    <option name='class' v-bind:value="n + 5" v-for="n in 8">{{n + 5}}. Клас</option>
  </select>
</template>

<script>
import {
  set_subjects,
  set_class
} from "../../vuex/test/actions.js"

export default {
  data () {
    return {
      classes: 0
    }
  },

  vuex: {
    actions: {
      set_subjects,
      set_class
    }
  },

  methods: {
    ClassSelected: function() {
      this.$http.post("/selectSubject", { class: this.classes }).then((response) => {
        var data = {
          class: this.class,
          subjects: response.data
        }

        this.set_class(data);

        this.$parent.subject = "default"
        this.$parent.partition = null
      }, (err) => {
        console.log(err);
      })
    }
  }
}
</script>
