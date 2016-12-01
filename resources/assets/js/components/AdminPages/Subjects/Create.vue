<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-book"></i>
        Добави предмет
      </h1>
    </div>

    <div class='box-content'>

      <alert :alert="alert" v-if="hasAlert"></alert>

      <form class="form form-horizontal" @submit.prevent="CreateSubject">
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
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="CreateSubject">
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

export default {
  data () {
    return {
      name: "",
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
    "select-class": SelectClass
  },

  methods: {
    CreateSubject() {
      var data = {
        name: this.name
      }

      if(this.classes > 0){
        data.class = this.classes
      }

      this.hasAlert = false

      this.$http.post('/api/subject', data).then( (response) => {
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
      }, (error) => {
        console.log(error);
      })
    }
  }
}
</script>

<style lang="css">
</style>
