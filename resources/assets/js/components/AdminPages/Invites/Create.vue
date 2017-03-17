<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-envelope"></i>
        Добавяне на покана
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="CreateInvite">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Покана</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Покана' type='text' v-model="invite">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>E-mail</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='E-mail' type='text' v-model="email">
          </div>
        </div>
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="CreateInvite">
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
export default {
  data () {
    return {
      invite: '',
      email: '',
      alert: {},
      hasAlert: false
    }
  },

  computed: {
    id() {
      return this.$route.params.id
    }
  },

  created () {
    let url = '/api/invite/create'

    if(this.id) {
      url = '/api/invite/create/' + this.id
    }

    this.$http.get(url).then(
      (response) => {
        this.email = response.data.invite.email
        this.invite = response.data.code
      }, console.error
    )
    this.$parent.isLoading = false
  },

  components: {
    "alert": Alert,
  },

  methods: {
    CreateInvite() {
      const sendData = {
        invite: this.invite,
        email: this.email,
        id: this.id
      }

      this.hasAlert=false
      this.$parent.isLoading = true

      this.$http.post('/api/invite', sendData).then( (response) => {
        let data = response.data

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
