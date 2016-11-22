<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-book"></i>
        Редактирай предмет
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="UpdateQuestion">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Името на предмета</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Името на предмета' type='text' v-model="name">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='class'>Клас</label>
          <div class='col-md-5'>
            <select-class></select-class>
          </div>
        </div>
        <div class='form-group' v-if="subject != null">
          <label class='col-md-2 control-label'>Предмет</label>
          <div class='col-md-5'>
            <select-subject :subject-id="subject"></select-subject>
          </div>
        </div>
        <div class='form-group' v-if="partition != null">
          <label class='col-md-2 control-label'>Раздел</label>
          <div class='col-md-5'>
            <select-partition :partition-id="partition"></select-partition>
          </div>
        </div>
        <answers :answers="answers"></answers>
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="UpdateQuestion">
                <i class='icon-save'></i>
                Запази
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Alert from "../../Alert.vue"
import SelectClass from "../../SelectInputs/SelectClass.vue"
import SelectSubject from "../../SelectInputs/SelectSubject.vue"
import SelectPartition from "../../SelectInputs/SelectPartition.vue"
import Answers from "./Answers.vue"

export default {
  data () {
    return {
      name: "",
      alert: {},
      subject: null,
      partition: null,
      answers: [],
      hasAlert: false
    }
  },

  computed: {
    id(){
      return this.$route.params.id
    },

    classes(){
      return this.$store.getters.Class
    }
  },

  components: {
    "alert": Alert,
    "select-class": SelectClass,
    "select-subject": SelectSubject,
    "select-partition": SelectPartition,
    "answers": Answers
  },

  created() {
    this.$http.get('/api/question/' + this.id + '/edit').then((response) => {
      this.name = response.data.question.name
      this.answers = response.data.question.answers

      this.$store.dispatch('set_class', response.data.question.class)

      this.subject = response.data.question.subject_id
      this.$store.dispatch('set_subjects', response.data.subjects)

      this.partition = response.data.question.partition_id
      this.$store.dispatch('set_partitions', response.data.partitions)
    }, (error) => {
      console.error(error);
    })
  },

  methods: {
    UpdateQuestion() {
      var data = {
        name: this.name,
        class: this.classes
      }

      this.hasAlert=false

      this.$http.put('/api/subject/'+this.id, data).then( (response) => {
        data = response.data

        if(data.success){
          this.hasAlert = true

          this.alert = {
            type: 'alert-success',
            messages: response.data.success
          }
        }else if (data.error) {

          this.alert.type = 'alert-danger'
          this.alert.messages = []
          if (Object.keys(data.error).length > 1) {
            for(var messages in data.error){
              for(var message in data.error[messages]){
                this.alert.messages.push(data.error[messages][message])
              }
            }
          }else {
            for(var message in data.error){
              this.alert.messages = data.error[message][0]
            }
          }
          this.hasAlert = true
        }
      }, console.error)
    }
  }
}
</script>

<style lang="css">
</style>
