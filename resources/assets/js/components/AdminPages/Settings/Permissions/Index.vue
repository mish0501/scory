<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-cogs"></i>
        Всички права
      </h1>

      <div class='pull-right' v-if="can('create-permission')">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'permissions/create' }">
            <i class='fa fa-plus'></i>
            Добави право
          </router-link>
        </div>
      </div>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <div class="responsive-table">
          <table class=' table table-bordered table-hover table-striped' style='margin-bottom:0;'>
            <thead>
              <tr>
                <th>
                  Име на правото
                </th>
                <th>
                  Име на правото в системата
                </th>
                <th>
                  Описание
                </th>
                </th>
                <th v-if="can('edit-permission')">
                  Опции
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="permission in permissions">
                <td>{{ permission.display_name }}</td>
                <td>{{ permission.name }}</td>
                <td>{{ permission.description }}</td>
                <td v-if="can('edit-permission')">
                  <div class='text-right'>
                    <router-link tag="a" :to="{ name: 'SettingsEditPermission', params: {id: permission.id } }" class='btn btn-success btn-xs'>
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
      permissions: {},
      hasAlert: false,
      alert: {}
    }
  },

  components: {
    "alert": Alert
  },

  computed:{
    isAdmin(){
      return this.$store.getters.User.role == 'admin'
    }
  },

  beforeCreate () {
    this.$parent.isLoading = true
    this.$http.get('/api/settings/permissions').then(
      (response) => {
        this.permissions = response.data

        this.$parent.setDataTable()

        this.$parent.isLoading = false
      }, console.error
    )
  }
}
</script>
