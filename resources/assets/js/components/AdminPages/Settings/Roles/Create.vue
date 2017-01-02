<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-cogs"></i>
        Добавяне на роля
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="CreateRole">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Името на ролята</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Името на ролята' type='text' v-model="role.display_name">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Името на ролята в системата</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Името на ролята в системата' type='text' v-model="role.name">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Описание</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Описание' type='text' v-model="role.description">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Права</label>
          <div class='col-md-5'>
            <multiselect
            v-model="selectedPermisions"
            :options="permissions"
            :max-height="150"
            :multiple="true"
            :allow-empty="false"
            :close-on-select="false"
            placeholder="Търси права"
            label="display_name"
            track-by="id"
            :selectLabel="'Натиснете Enter, за да изберете'"
            :selectedLabel="'Избран'"
            :deselectLabel="'Натиснете Enter, за да се премахне'"
            :hide-selected="false"
            :limit="1"
            :limitText="count => `и още ${count}`"
            >
            </multiselect>
          </div>
        </div>
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="CreateRole">
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
import Multiselect from 'vue-multiselect'
export default {
  name: 'SettingsEditRole',
  data () {
    return {
      role: {},
      permissions: [],
      selectedPermisions: [],
      hasAlert: true,
      alert: {}
    }
  },

  components: {
    "alert": Alert,
    'multiselect': Multiselect
  },

  created () {
    this.$http.get('/api/settings/roles/create').then(
      (response) => {
        this.permissions = response.data
      }, console.error
    )
  },

  methods: {
    CreateRole () {
      const sendData = {
        name: this.role.name,
        display_name: this.role.display_name,
        description: this.role.description,
        permissions: this.selectedPermisions.map(el => el.id)
      }

      this.hasAlert = false

      this.$http.post('/api/settings/roles/create', sendData).then(
        (response) => {
          const data = response.data

          if(data.success){
            this.hasAlert = true

            this.alert = {
              type: 'alert-success',
              messages: response.data.success
            }

            this.role = {}
            this.selectedPermisions = []
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
