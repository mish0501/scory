<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-envelope"></i>
        Всички покани
      </h1>

      <div class='pull-right' v-if="isAdmin">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'invite/create' }">
            <i class='icon-plus'></i>
            Създай покана
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
                  Поканата
                </th>
                <th>
                  E-mail
                </th>
                <th v-if="isAdmin">
                  Опции
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="invite in invites">
                <td>{{ hasInvite(invite) }}</td>
                <td>{{ invite.email }}</td>
                <td v-if="isAdmin">
                  <div class='text-right'>
                      <button class="btn btn-danger btn-xs" @click="DeleteInvite(invite.id)">
                        <i class="icon-remove"></i>
                        <span>Изтрий</span>
                      </button>
                      <router-link
                        tag="a"
                        class="btn btn-success btn-xs"
                        :to="{ name:'CreateInvite', params:{ id: invite.id }}"
                        v-if="!hasInvite(invite)"
                      >
                        <i class='icon-mail-forward'></i>
                        <span>Изпрати покана</span>
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
import Alert from "../../Alert.vue"
export default {
  data () {
    return {
      invites: [],
      invitesIds: [],
      hasAlert: false,
      alert: {},
    }
  },

  components: {
    "alert": Alert
  },

  beforeCreate () {
    this.$parent.isLoading = true
    this.$http.get('/api/invite').then(
      (response) => {
        this.invites = response.data
        this.invitesIds = response.data.map(el => el.id)
        this.$parent.isLoading = false

        this.$nextTick(() => {
          $(".table").dataTable({
            sPaginationType: "bootstrap",
            fnDrawCallback () {
              return $(".dataTables_wrapper").addClass("scrollable-area");
            }
          })
        })
      }, (error) => {
        console.log(error);
      }
    )
  },

  computed:{
    isAdmin(){
      return this.$store.getters.User.role == 'admin'
    }
  },

  methods: {
    DeleteInvite(id) {
      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.delete('/api/invite/' + id).then((response) => {
        this.hasAlert = true

        this.alert = {
          type: 'alert-success',
          messages: response.data.success
        }

        const index = this.invitesIds.indexOf(id)
        this.invites.splice(index, 1)
        this.invitesIds.splice(index, 1)
        this.$parent.isLoading = false
      }, console.error)
    },

    hasInvite(i) {
      return (i.invite !== null) ? i.invite : 'Няма изпратена покана'
    }
  }
}
</script>

<style lang="css">
</style>
