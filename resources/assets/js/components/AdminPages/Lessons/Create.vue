<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-file"></i>
        Добави урок
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="CreateLesson">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Името на урока</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Името на урока' type='text' v-model="name">
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
        <div class='form-group' v-if="partition != null">
          <label class='col-md-2 control-label'>Текст</label>
          <div class='col-md-5'>
            <textarea class="form-control" placeholder="Текст" v-model="text" rows="8" cols="80"></textarea>
          </div>
        </div>
        <div class='form-group'>
          <div class="col-md-4 col-md-offset-7">
            <h1>test</h1>
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

export default {
  data () {
    return {
      name: "",
      alert: {},
      subject: null,
      partition: null,
      hasAlert: false,
      isLoading: false,
      text: ""
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
  },

  components: {
    "alert": Alert,
    "select-class": SelectClass,
    "select-subject": SelectSubject,
    "select-partition": SelectPartition
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

    CreateLesson() {
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
