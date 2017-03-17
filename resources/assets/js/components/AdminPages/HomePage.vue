<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-dashboard"></i>
        <span>Начало</span>
      </h1>
    </div>

    <div class="col-sm-2" v-if="invites">
      <div class="box-content box-statistic">
        <h3 class="title text-error">{{ invites }}</h3>
        <small>Покани</small>
        <div class="text-error fa fa-envelope align-right"></div>
      </div>
    </div>
    <div class="col-sm-2" v-if="users">
      <div class="box-content box-statistic">
        <h3 class="title text-warning">{{ users }}</h3>
        <small>Потребители</small>
        <div class="text-warning fa fa-user align-right"></div>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-info">{{ subjects }}</h3>
        <small>Предмети</small>
        <div class="text-info fa fa-book align-right"></div>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-primary">{{ partitions }}</h3>
        <small>Раздели</small>
        <div class="text-primary fa fa-folder-open align-right"></div>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="box-content box-statistic">
        <h3 class="title text-success">{{ questions }}</h3>
        <small>Въпроси</small>
        <div class="text-success fa fa-question align-right"></div>
      </div>
    </div>
    <div class="col-sm-2" v-if="trash != null">
      <div class="box-content box-statistic">
        <h3 class="title text-muted">{{ trash }}</h3>
        <small>В кошчето</small>
        <div class="text-muted fa fa-trash align-right"></div>
      </div>
    </div>
    <div class="col-sm-2" v-if="testrooms">
      <div class="box-content box-statistic">
        <h3 class="title text-muted">{{ testrooms }}</h3>
        <small>Стаи</small>
        <div class="text-muted fa fa-group align-right"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminHomePage",
  data () {
    return {
      subjects: {},
      partitions: {},
      invites: {},
      questions: {},
      users: {},
      testrooms: {},
      trash: {}
    }
  },

  beforeCreate() {
    this.$parent.isLoading = true
    this.$http.post('/api/getDashboardInfo').then(
      (response) => {
        const data = response.data

        this.subjects = data.subjects
        this.partitions = data.partitions
        this.invites = data.invites
        this.questions = data.questions
        this.users = data.users
        this.testrooms = data.testrooms
        this.trash = data.trash
        this.$parent.isLoading = false
      }, (error) =>{
        console.log(error);
      }
    )
  }
}
</script>
