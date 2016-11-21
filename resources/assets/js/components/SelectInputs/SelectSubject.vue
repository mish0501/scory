<template>
  <select class="form-control subject" v-model="subject" v-on:change="SubjectSelected">
    <option disabled value="0">Избери си предмет</option>
    <option v-bind:value="subject.id" v-for="subject in subjects">{{ subject.name }}</option>
  </select>
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

  data () {
    return{
      subject: this.subjectId
    }
  },

  methods: {
    SubjectSelected: function() {
      if (this.$parent.partition) {
        this.$parent.partition = null
      }
      
      this.$http.post("/api/selectPartitions", { class: this.class, subject_id: this.subject }).then((response) => {

        this.$store.dispatch('set_partitions', response.data)

        this.$parent.subject = this.subject

        if(this.$parent.partition == null){
          this.$parent.partition = 0
        }

        if(this.$parent.title){
          this.$parent.title = "Избери си раздел"
        }

      }, (err) => {
        console.log(err);
      })
    }
  }
}
</script>
