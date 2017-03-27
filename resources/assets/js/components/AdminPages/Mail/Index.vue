<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-comments"></i>
        Всички съобщения
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
                  Име
                </th>
                <th>
                  Относно
                </th>
                <th>
                  Съобщение
                </th>
                <th>
                  Статус
                </th>
                <th>
                  Получено
                </th>
                <th v-if="can('show-mail') || can('delete-mail')">
                  Опции
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="message in mail">
                <td>{{ message.name }} ({{ message.email }})</td>
                <td>{{ message.subject }}</td>
                <td>{{ message.message }}</td>
                <td>{{ (message.read == true)? 'Прочетено' : 'Непрочетено' }}</td>
                <td>{{ message.time }}</td>
                <td v-if="can('show-mail') || can('delete-mail')">
                  <div class='text-right'>
                      <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'ShowMail', params:{ id: message.id }}" v-if="can('show-mail')">
                        <i class="fa fa-edit"></i>
                        <span>Отвори</span>
                      </router-link>
                      <button class="btn btn-danger btn-xs" @click="DeleteMail(message.id)" v-if="can('delete-mail')">
                        <i class="fa fa-remove"></i>
                        <span>Изтрий</span>
                      </button>
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
      mail: [],
      mailIds: [],
      hasAlert: false,
      alert: {}
    }
  },

  beforeCreate () {
    this.$parent.isLoading = true
    this.$http.get('/api/mail').then(
      (response) => {
        this.mail = response.data
        this.mailIds = response.data.map(el => el.id)

        this.$parent.setDataTable()

        this.$parent.isLoading = false
      }, (error) => {
        console.log(error);
      }
    )

    Echo.private('MailChannel')
      .listen('NewMail', (e) => {
        if(e.new_mail) {
          this.$http.post('/api/getMessage').then(
            (response) => {
              console.log(response.data);
              this.mail.reverse()
              this.mail.push(response.data)
              this.mail.reverse()

              this.mailIds.push(response.data.id)
            }, (error) => {
              console.log(error);
            }
          )
        }
      })
  },

  components: {
    "alert": Alert
  },

  computed:{
    isAdmin(){
      return this.$store.getters.User.role == 'admin'
    }
  },

  methods: {
    DeleteMail(id) {
      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.delete('/api/mail/' + id).then((response) => {
        this.hasAlert = true

        this.alert = {
          type: 'alert-success',
          messages: response.data.success
        }

        const index = this.mailIds.indexOf(id)

        this.$parent.table.fnDestroy()

        this.mail.splice(index, 1)
        this.mailIds.splice(index, 1)

        this.$parent.setDataTable()
        this.$parent.isLoading = false
      }, (error) => {
        console.error(error);
      })
    }
  }
}
</script>
