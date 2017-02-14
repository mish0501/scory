<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-cogs"></i>
        Всички роли
      </h1>

      <div class='pull-right' v-if="isAdmin">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'roles/create' }">
            <i class='icon-plus'></i>
            Добави роля
          </router-link>
        </div>
      </div>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <div class="responsive-table">
          <div class="scrollable-area">
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
                  <th>
                    Опции
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="role in roles">
                  <td>{{ role.display_name }}</td>
                  <td>{{ role.name }}</td>
                  <td>{{ role.description }}</td>
                  <td>
                    <div class='text-right'>
                      <router-link tag="a" :to="{ name: 'SettingsEditRole', params: {id: role.id } }" class='btn btn-success btn-xs'>
                        <i class='icon-edit'></i>
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
  </div>
</template>

<script>
import Alert from "../../../Alert.vue"
export default {
  data () {
    return {
      roles: {},
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
    this.$http.get('/api/settings/roles').then(
      (response) => {
        this.roles = response.data
        this.$parent.isLoading = false

        this.$nextTick(() => {
          $(".table").dataTable({
            sPaginationType: "bootstrap",
            fnDrawCallback () {
              return $(".dataTables_wrapper").addClass("scrollable-area");
            }
          })
        })
      }, console.error
    )
  }
}
</script>

<style lang="css">
</style>
