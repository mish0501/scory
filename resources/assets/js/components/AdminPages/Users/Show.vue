<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-user"></i>
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
        </div>
      </div>
      <div class='col-sm-9 col-lg-7'>
        <div class='box'>
          <div class='box-content box-double-padding'>
            <div class='col-sm-12'>
              <div class='form-group'>
                <label>Име:</label><br>
                <span>{{ name }}</span>
              </div>
              <div class='form-group'>
                <label>E-mail:</label><br>
                <span>{{ email }}</span>
              </div>
              <div class='form-group'>
                <label>Въпроси в системата:</label><br>
                <span>{{ questions }}</span>
              </div>
              <div class='form-actions form-actions-padding' style='margin-bottom: 0;' v-if="edit">
                <div class='text-right'>
                  <router-link :tag="a" :to="{ name: 'UserEdit' }" class='btn btn-success btn-lg'>
                    <i class='icon-edit'></i>
                    Редактирай
                  </router-link>
                </div>
              </div>
            </div>
          </div>
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
      name: "",
      email: "",
      questions: "",
      avatar: "",
      edit: false,
      alert: {},
      hasAlert: false
    }
  },

  computed: {
    id(){
      return this.$route.params.id
    }
  },

  components: {
    "alert": Alert
  },

  created() {
    this.$http.get('/api/user/' + this.id).then((response) => {
      let data = response.data

      this.name = data.name
      this.email = data.email
      this.questions = data.questions
      this.avatar = data.avatar
      this.edit = data.edit
    }, (error) => {
      console.error(error);
    })
  }
}
</script>

<style lang="css">
</style>
