<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-book"></i>
        Добави въпрос
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="CreateQuestion">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Въпрос</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Въведете въпроса' type='text' v-model="name">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='class'>Клас</label>
          <div class='col-md-5'>
            <select-class @classSelected="classSelected"></select-class>
          </div>
        </div>
        <div class='form-group' v-if="subject != null">
          <label class='col-md-2 control-label'>Предмет</label>
          <div class='col-md-5'>
            <select-subject :subject-id="subject" @subjectSelected="subjectSelected"></select-subject>
          </div>
        </div>
        <div class='form-group' v-if="partition != null">
          <label class='col-md-2 control-label'>Раздел</label>
          <div class='col-md-5'>
            <select-partition :partition-id="partition" @partitionSelected="partitionSelected"></select-partition>
          </div>
        </div>
        <answers :answers="answers"></answers>
        <div class='form-group'>
          <div class='col-md-5 col-md-offset-2'>
            <button class='btn btn-success add-answer' :disabled="!canAdd" @click.prevent="AddAnswer()">
              <i class='fa fa-plus'></i>
              Добави още един отговор
            </button>
            <br class="hidden-lg hidden-sm">
            <br class="hidden-lg hidden-sm">
            <button class='btn btn-danger remove-answer' :disabled="!canRemove" @click.prevent="RemoveAnswer()">
              <i class='fa fa-remove'></i>
              Изтрий последния въпрос
            </button>
          </div>
        </div>
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="CreateQuestion">
                <i class='fa fa-save'></i>
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
      type: 'one',
      alert: {},
      subject: null,
      partition: null,
      answers: [
        {
          name: "",
          correct: true
        },
        {
          name: "",
          correct: false
        },
        {
          name: "",
          correct: false
        },
        {
          name: "",
          correct: false
        }
      ],
      hasAlert: false,
      isLoading: false
    }
  },

  watch: {
    isLoading (newValue) {
      this.$parent.isLoading = newValue
    }
  },

  computed: {
    classes(){
      return this.$store.getters.Class
    },

    answerCount() {
      return this.answers.length
    },

    canAdd(){
      return (this.answerCount + 1) <= 8
    },

    canRemove(){
      return this.answers.length - 1 >= 4
    }
  },

  components: {
    "alert": Alert,
    "select-class": SelectClass,
    "select-subject": SelectSubject,
    "select-partition": SelectPartition,
    "answers": Answers
  },

  methods: {
    classSelected(data){
      this.subject = data.subject
      this.partition = data.partition
    },

    subjectSelected(data){
      this.subject = data.subject
      this.partition = data.partition
    },

    partitionSelected(data){
      this.partition = data.partition
    },

    AddAnswer(){
      const newAnswer = {
        name: "",
        id: 1,
        correct: false
      }
      this.answers.push(newAnswer)
    },

    RemoveAnswer(){
      const index = this.answers.length -1

      this.answers.splice(index, 1)
    },

    CreateQuestion() {
      var data = {
        name: this.name,
        subject_id: this.subject,
        partition_id: this.partition,
        answers: this.answers,
        type: this.type,
      }

      if(this.classes != 0){
        data.class = this.classes
      }

      this.hasAlert=false
      this.$parent.isLoading = true

      this.$http.post('/api/question', data).then( (response) => {
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
        this.$parent.isLoading = false
      }, console.error)
    }
  }
}
</script>

<style lang="css">
</style>
