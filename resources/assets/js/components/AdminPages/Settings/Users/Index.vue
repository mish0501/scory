<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-cogs"></i>
        Всички потребители
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <div class="responsive-table">
          <table class=' table table-bordered table-hover table-striped' style='margin-bottom:0;'>
            <thead>
              <tr>
                <th>
                  Име на потребителя
                </th>
                <th>
                  E-mail
                </th>
                <th>
                  Роля
                </th>
                </th>
                <th>
                  Опции
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.role.display_name }}</td>
                <td>
                  <div class='text-right'>
                    <router-link tag="a" :to="{ name: 'SettingsEditUser', params: {id: user.id } }" class='btn btn-success btn-xs'>
                      <i class='fa fa-edit'></i>
                      <span>Редактирай</span>
                    </router-link>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Alert from "../../../Alert.vue"
export default {
  data () {
    return {
      users: {},
      hasAlert: false,
      alert: {}
    }
  },

  components: {
    "alert": Alert
  },

  beforeCreate () {
    this.$parent.isLoading = true
    this.$http.get('/api/settings/users').then(
      (response) => {
        this.users = response.data

        this.$parent.setDataTable()
        
        this.$parent.isLoading = false
      }, console.error
    )
  }
}
</script>

<style lang="css">
</style>
