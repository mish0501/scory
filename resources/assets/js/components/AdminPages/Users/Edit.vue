<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-user"></i>
          Настройки на профила
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='row'>
      <div class='col-sm-3 col-lg-3 col-lg-offset-1'>
        <div class='box' style="display:inline-block;">
          <div class='box-content' style="display:inherit;">
            <img class="img-responsive" :src="avatar " v-if="avatar"/>
          </div>
          <button type="button" class="btn btn-primary" @click="openFileManager">
            Смени профилната снимка
          </button>
        </div>
      </div>
      <div class='col-sm-9 col-lg-7'>
        <div class='box'>
          <div class='box-content box-double-padding'>
            <form class="form form-horizontal" @submit.prevent="UpdateUser">
              <fieldset>
                <div class='col-sm-12'>
                  <div class='form-group'>
                    <label>Име</label>
                    <input class='form-control' placeholder='Име' type='text' v-model="name">
                  </div>
                  <div class='form-group'>
                    <label>E-mail</label>
                    <input class='form-control' placeholder='E-mail' type='email' v-model="email">
                  </div>
                </div>
              </fieldset>
              <!-- <hr class='hr-normal'>
              <fieldset>
                <div class='col-sm-12'>
                  <div class='form-group'>
                    <label>Учител по</label>
                    <input class='form-control' placeholder='Учител по...' type='text'>
                  </div>
                  <div class='form-group'>
                    <label>Учител в</label>
                    <input class='form-control' placeholder='Името на учебното заведение' type='text'>
                  </div>
                  <hr class='hr-normal'>
                  <div class='form-group'>
                    <label>Биография</label>
                    <textarea class='autosize form-control' placeholder='Биография'></textarea>
                  </div>
                </div>
              </fieldset> -->
              <div class='form-actions form-actions-padding' style='margin-bottom: 0;'>
                <div class='text-right'>
                  <button type="submit" class='btn btn-primary btn-lg' @click.prevent="UpdateUser">
                    <i class='fa fa-save'></i>
                    Запази
                  </button>
                </div>
              </div>
            </form>
            <hr class='hr-normal'>
            <form class="form form-horizontal" @submit.prevent="ChangePass">
              <fieldset>
                <div class='col-sm-12'>
                  <div class='form-group'>
                    <div class='controls'>
                      <h3>Смяна на паролата</h3>
                    </div>
                  </div>
                  <div class='form-group'>
                    <label>Стара парола</label>
                    <input class='form-control' placeholder='Стара парола' type='password' v-model="old_pass">
                  </div>
                  <div class='form-group'>
                    <label>Нова парола</label>
                    <input class='form-control' placeholder='Нова парола' type='password' v-model="new_pass">
                  </div>
                  <div class='form-group'>
                    <label>Потвърди новата парола</label>
                    <input class='form-control' placeholder='Потвърди новата парола' type='password' v-model="confirm_pass">
                  </div>
                </div>
              </fieldset>
              <div class='form-actions form-actions-padding' style='margin-bottom: 0;'>
                <div class='text-right'>
                  <button type="submit" class='btn btn-danger btn-lg' @click.prevent="ChangePass">
                    <i class='fa fa-key'></i>
                    Смени паролата
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Alert from "../../Alert.vue"

export default {
  name: "EditUserProfile",
  data () {
    return {
      name: "",
      email: "",
      avatar: "",
      old_pass: "",
      new_pass: "",
      confirm_pass: "",
      alert: {},
      hasAlert: false
    }
  },

  components: {
    "alert": Alert
  },

  created() {
    this.$parent.isLoading = true
    this.$http.get('/api/user/edit').then((response) => {
      this.name = response.data.name
      this.email = response.data.email
      this.avatar = response.data.avatar
      this.$parent.isLoading = false
    }, (error) => {
      console.error(error);
    })
  },

  mounted() {
    $(window).on('message', this.onMessage)
  },

  destroyed () {
    $(window).off('message', this.onMessage)
  },

  methods: {
    UpdateUser() {
      var data = {
        name: this.name,
        email: this.email
      }

      this.hasAlert=false

      this.$http.put('/api/user/edit', data).then( (response) => {
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
      }, console.error)
    },

    ChangePass () {
      let data = {
        'old_password': this.old_pass,
        'password': this.new_pass,
        'password_confirmation': this.confirm_pass
      }

      this.$http.post('/api/user/changepass', data).then(
        (response) => {
          data = response.data

          if(data.success){
            this.hasAlert = true

            this.old_pass = ""
            this.new_pass = ""
            this.confirm_pass = ""

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
    },

    onMessage (e) {
      const data = e.originalEvent.data

      if (!data.selecteds) {
        return
      }

      this.$parent.isLoading = true
      this.$http.post('/api/user/changeavatar', { id: data.selecteds }).then(
       (response) => {
         this.avatar = response.data

         $('#avatar').attr('src', response.data)
         this.$parent.isLoading = false
       }, console.error
      )
    },

    openFileManager () {
      let width = parseInt((window.screen.width * 80) / 100, 10)
      let height = parseInt((window.screen.height * 70) / 100, 10)

      if (width < 640) {
        width = 640
      }

      if (height < 420) {
        height = 420
      }

      const top = parseInt((window.screen.height - height) / 2, 10)
      const left = parseInt((window.screen.width - width) / 2, 10)

      const options = `location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes,width=${width},height=${height},top=${top},left=${left}`
      let avatar = window.open('/file/manager', null, options)

      avatar.fileCount = 'one'
    }
  }
}
</script>

<style lang="css">
</style>
