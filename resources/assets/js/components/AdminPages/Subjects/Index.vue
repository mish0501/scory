<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-book"></i>
        Всички предмети
      </h1>

      <div class='pull-right' v-if="isAdmin">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'subject/create' }">
            <i class='icon-plus'></i>
            Добави предмет
          </router-link>
        </div>
      </div>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
          <thead>
            <tr>
              <th>
                Име на предмета
              </th>
              <th>
                Клас
              </th>

              <th v-if="isAdmin">
                Опции
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="subject in subjects">
              <td>{{ subject.name }}</td>
              <td class="class-col">{{ subject.class }}. Клас</td>
              <td v-if="isAdmin">
                <div class='text-right'>
                    <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'EditSubject', params:{ id: subject.id }}">
                      <i class="icon-edit"></i>
                      <span>Редактирай</span>
                    </router-link>
                    <button class="btn btn-danger btn-xs" @click="DeleteSubject(subject.id)">
                      <i class="icon-remove"></i>
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
</template>

<script>
import Alert from "../../Alert.vue"
export default {
  data () {
    return {
      subjects: [],
      subjectsIds: [],
      hasAlert: false,
      alert: {}
    }
  },

  components: {
    "alert": Alert
  },

  beforeCreate () {
    this.$http.get('/api/subject').then(
      (response) => {
        this.subjects = response.data
        this.subjectsIds = response.data.map(el => el.id)
      }, (error) => {
        console.log(error);
      }
    )

    this.$store.dispatch('reset_test')
  },

  computed:{
    isAdmin(){
      return this.$store.getters.User.role == 'admin'
    }
  },

  methods: {
    DeleteSubject(id) {
      this.hasAlert = false

      this.$http.delete('/api/subject/' + id).then((response) => {
        this.hasAlert = true

        this.alert = {
          type: 'alert-success',
          messages: response.data.success
        }

        const index = this.subjectsIds.indexOf(id)
        this.subjects.splice(index, 1)
        this.subjectsIds.splice(index, 1)
      }, (error) => {
        console.error(error);
      })
    }
  }
}
</script>

<style lang="css">
</style>
