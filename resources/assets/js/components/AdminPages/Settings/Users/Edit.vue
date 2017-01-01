<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-cogs"></i>
        Всички потребители
      </h1>

      <div class='pull-right' v-if="isAdmin">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'subject/create' }">
            <i class='icon-plus'></i>
            Добави предмет
          </router-link>
        </div>
      </div>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="UpdateUser">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Името на потребителя</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Името на потребителя' type='text' v-model="user.name">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>E-mail на потребителя</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='E-mail на потребителя' type='text' v-model="user.email">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='class'>Роля</label>
          <div class='col-md-5'>
            <select class="form-control" v-model="roleId">
              <option v-for="role in roles" :value="role.id">{{ role.display_name }}</option>
            </select>
          </div>
        </div>
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="UpdateUser">
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
import Alert from "../../../Alert.vue"
export default {
  data () {
    return {
      user: {},
      roleId: 0,
      roles: [],
      hasAlert: true,
      alert: {}
    }
  },

  components: {
    "alert": Alert
  },

  computed: {
    id(){
      return this.$route.params.id
    },
  },

  created () {
    this.$http.get('/api/settings/users/'+this.id+'/edit').then(
      (response) => {
        this.user = response.data.user
        this.roles = response.data.roles
        this.roleId =this.user.role.id
      }, console.error
    )
  },

  methods: {
    UpdateUser () {
      const sendData = {
        name: this.user.name,
        email: this.user.email,
        role: this.roleId
      }

      this.hasAlert = false

      this.$http.post('/api/settings/users/' + this.id + '/edit', sendData).then(
        (response) => {
          const data = response.data

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
        }, console.error
      )
    }
  }
}
</script>

<style lang="css">
</style>
