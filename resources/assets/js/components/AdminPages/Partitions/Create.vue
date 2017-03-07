<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-book"></i>
        Добави раздел
      </h1>
    </div>

    <div class='box-content'>

      <alert :alert="alert" v-if="hasAlert"></alert>

      <form class="form form-horizontal" @submit.prevent="CreatePartition">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Името на раздела</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Въведете името на предмета' type='text' v-model="name">
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
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="CreatePartition">
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

export default {
  data () {
    return {
      name: "",
      subject: null,
      alert: {},
      hasAlert: false
    }
  },


  computed: {
    classes(){
      return this.$store.getters.Class
    }
  },

  components: {
    "alert": Alert,
    "select-class": SelectClass,
    "select-subject": SelectSubject
  },

  methods: {
    classSelected(data){
      this.subject = data.subject
    },

    subjectSelected(data){
      this.subject = data.subject
    },

    CreatePartition() {
      var data = {
        name: this.name
      }

      if(this.classes > 0){
        data.class = this.classes
      }

      if(this.subject > 0){
        data.subject_id = this.subject
      }

      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.post('/api/partition', data).then( (response) => {
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
      }, (error) => {
        console.log(error);
      })
    }
  }
}
</script>
