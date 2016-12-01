<template>
  <select class="form-control subject" v-model="subject" v-on:change="SubjectSelected">
    <option disabled value="0">Избери си предмет</option>
    <option v-bind:value="subject.id" v-for="subject in subjects">{{ subject.name }}</option>
  </select>
  {{ getSubject }}
</template>

<script>

export default {
  props: {
    subjectId: {
      required: true
    }
  },

  computed: {
    class () {
      return this.$store.getters.Class
    },

    subjects () {
      return this.$store.getters.Subjects
    }
  },

  watch: {
    subjectId (newSubjectId) {
      this.subject = newSubjectId
    }
  },

  data () {
    return{
      subject: this.subjectId
    }
  },

  methods: {
    SubjectSelected: function() {
      this.$http.post("/api/selectPartitions", { class: this.class, subject_id: this.subject }).then((response) => {

        this.$store.dispatch('set_partitions', response.data)


        this.$emit('subjectSelected', {
          subject: this.subject,
          partition: 0,
          title: "Избери си раздел"
        })
      }, (err) => {
        console.log(err);
      })
    }
  }
}
</script>
