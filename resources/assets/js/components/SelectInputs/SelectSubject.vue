<template>
  <select class="form-control subject" v-model="subject" v-on:change="SubjectSelected">
    <option selected="selected" disabled value="default">Избери си предмет</option>
    <option value="{{ subject.id }}" v-for="subject in subjects">{{ subject.name }}</option>
  </select>
</template>

<script>
import {
  set_partitions
} from "../../vuex/test/actions.js"

import { Subjects, Class } from "../../vuex/test/getters.js"

export default {

  props: {
    subject: {
      required: true
    }
  },

  vuex: {
    actions: {
      set_partitions
    },
    getters: {
      subjects: Subjects,
      class: Class
    }
  },

  methods: {
    SubjectSelected: function() {
      this.$http.post("/choosePartition", { class: this.class, subject_id: this.subject }).then((response) => {

        this.set_partitions(response.data)

        this.$parent.partition = "default"
      }, (err) => {
        console.log(err);
      })
    }
  }
}
</script>
