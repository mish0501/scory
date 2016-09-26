<template>
  <select class="form-control" v-model="subject" v-on:change="SubjectSelected">
    <option selected="selected" disabled value="default">Избери си предмет</option>
    <option value="{{ subject.id }}" v-for="subject in subjects">{{ subject.name }}</option>
  </select>
</template>

<script>
export default {
  props: {
    subjects: {
      required: true
    },
    subject: {
      required: true
    },
    class: {
      required: true
    }
  },

  methods: {
    SubjectSelected: function() {
      this.$http.post("/choosePartition", { class: this.class, subject_id: this.subject}).then((response) => {
        this.$dispatch('subjectSelected', { subject: this.subject, partitions: response.data })
      }, (err) => {
        console.log(err);
      })
    }
  }
}
</script>
