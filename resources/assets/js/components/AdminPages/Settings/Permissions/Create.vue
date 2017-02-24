<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-cogs"></i>
        Създаване на право
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="CreatePermission">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Името на правото</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Името на правото' type='text' v-model="permission.display_name">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Името на правото в системата</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Името на правото в системата' type='text' v-model="permission.name">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Описание</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Описание' type='text' v-model="permission.description">
          </div>
        </div>
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="CreatePermission">
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
import Alert from "../../../Alert.vue"
export default {
  data () {
    return {
      permission: {
        name: '',
        display_name: '',
        description: ''
      },
      hasAlert: true,
      alert: {}
    }
  },

  components: {
    "alert": Alert
  },

  methods: {
    CreatePermission () {
      const sendData = {
        name: this.permission.name,
        display_name: this.permission.display_name,
        description: this.permission.description
      }

      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.post('/api/settings/permissions/create', sendData).then(
        (response) => {
          const data = response.data

          if(data.success){
            this.hasAlert = true

            this.alert = {
              type: 'alert-success',
              messages: response.data.success
            }

            this.permission = {
              name: '',
              display_name: '',
              description: ''
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
        }, console.error
      )
    }
  }
}
</script>

<style lang="css">
</style>
