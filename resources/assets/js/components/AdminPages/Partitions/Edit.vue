<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-book"></i>
        Редактирай раздел
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="UpdateSubject">
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
          <label class='col-md-2 control-label' for='class'>Предмет</label>
          <div class='col-md-5'>
            <select-subject :subject-id="subject"></select-subject>
          </div>
        </div>
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="UpdateSubject">
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
    "select-subject": SelectSubject
  },

  created() {
    this.$http.get('/api/partition/' + this.id + '/edit').then((response) => {
      this.name = response.data.partition.name
      this.subject = response.data.partition.subject_id

      this.classes = response.data.partition.class
      this.$store.dispatch('set_class', response.data.partition.class)
      this.$store.dispatch('set_subjects', response.data.subjects)
    }, (error) => {
      console.error(error);
    })
  },

  methods: {
    UpdateSubject() {
      var data = {
        name: this.name,
        class: this.classes,
      }

      if(this.subject > 0){
        data.subject_id = this.subject
      }

      console.log(data);
      this.hasAlert=false

      this.$http.put('/api/partition/'+this.id, data).then( (response) => {
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
