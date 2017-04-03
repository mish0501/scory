<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-book"></i>
        Всички стаи
      </h1>

      <div class='pull-right'>
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'testroom/create' }">
            <i class='fa fa-plus'></i>
            Нова стая
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
                  Код
                </th>
                <th>
                  Предмет
                </th>
                <th>
                  Раздел
                </th>
                <th>
                  Клас
                </th>
                <th>
                  Статус
                </th>
                <th>
                  Опции
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="testroom in testrooms">
                <td>{{ testroom.code }}</td>
                <td>{{ testroom.subject.name }}</td>
                <td>{{ testroom.partition.name }}</td>
                <td>{{ testroom.class }}</td>
                <td>{{ status(testroom.status) }}</td>
                <td>
                  <div class='text-right'>
                      <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'ActivateTestroom', params:{ code: testroom.code }}" v-if="testroom.status == 0">
                        <i class="fa fa-check"></i>
                        <span>Активирай</span>
                      </router-link>

                      <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'StartTestroom', params:{ code: testroom.code }}" v-if="testroom.status == 1">
                        <i class="fa fa-play"></i>
                        <span>Старт</span>
                      </router-link>
                      <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'ActivateTestroom', params:{ code: testroom.code }}" v-if="testroom.status == 1">
                        <i class="fa fa-group"></i>
                        <span>Ученици</span>
                      </router-link>

                      <a class="btn btn-success btn-xs" @click="StopTest(testroom.code)" v-if="testroom.status == 2">
                        <i class="fa fa-stop"></i>
                        <span>Стоп</span>
                      </a>
                      <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'StartTestroom', params:{ code: testroom.code }}" v-if="testroom.status == 2">
                        <i class="fa fa-group"></i>
                        <span>Резултати</span>
                      </router-link>

                      <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'ResultsTestroom', params:{ code: testroom.code }}" v-if="testroom.status == 3">
                        <i class="fa fa-group"></i>
                        <span>Резултати</span>
                      </router-link>

                      <a class="btn btn-primary btn-xs" @click="Download(testroom.code)" v-if="testroom.status == 3">
                        <i class="fa fa-download"></i>
                        <span>Изтегли</span>
                      </a>

                      <button class="btn btn-danger btn-xs" @click="DeleteTestroom(testroom.code, testroom.id)">
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
  name: 'TestRoomIndex',
  data () {
    return {
      testrooms: [],
      testroomsIds: [],
      hasAlert: false,
      alert: {}
    }
  },

  components: {
    "alert": Alert
  },

  created() {
    if(this.userId){
      this.getTestrooms()
    }
  },

  computed: {
    userId () {
      return this.$store.getters.User.id
    }
  },

  watch: {
    userId (newUserId) {
      if(newUserId){
        this.getTestrooms()
      }
    }
  },

  methods: {
    status(status) {
      if (status == 0) {
        return "Деактивирана"
      }else if (status == 1) {
        return "Активна"
      }else if (status == 2) {
        return "В процес на решаване на тест"
      }else if (status == 3) {
        return "Решена"
      }
    },

    getTestrooms(){
      const userId = this.userId
      this.$parent.isLoading = true
      this.$http.get('/api/testroom/' + userId).then(
        (response) => {
          this.testrooms = response.data
          this.testroomsIds = response.data.map(el => el.id)

          this.$parent.setDataTable()

          this.$parent.isLoading = false
        }, (error) => {
          console.log(error);
        }
      )
    },

    StopTest(code){
      this.$parent.isLoading = true
      this.$http.get('/api/testroom/'+code+'/end').then(
        (response) => {
          if(response.data.success){
            this.$http.get('/api/testroom/' + this.user.id).then(
              (response) => {
                this.testrooms = response.data
                this.testroomsIds = response.data.map(el => el.id)
                this.$parent.isLoading = false
              }, (error) => {
                console.log(error);
              }
            )
          }
        },(error) => {
          console.error(error);
        }
      )
    },

    Download(code) {
      this.$http.get('/api/testroom/' + code + '/download').then(
        (response) => {
          console.log(response);
        }, console.error
      )
    },

    DeleteTestroom(code, id) {
      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.delete('/api/testroom/' + code).then((response) => {
        this.hasAlert = true

        this.alert = {
          type: 'alert-success',
          messages: response.data.success
        }

        const index = this.testroomsIds.indexOf(id)

        this.$parent.table.fnDestroy()

        this.testrooms.splice(index, 1)
        this.testroomsIds.splice(index, 1)

        this.$parent.setDataTable()

        this.$parent.isLoading = false
      }, (error) => {
        console.error(error);
      })
    }
  }
}
</script>
