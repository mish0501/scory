<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-file"></i>
        Всички уроци
      </h1>

      <div class='pull-right' v-if="can('create-lesson')">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'lesson/create' }">
            <i class='fa fa-plus'></i>
            Добави урок
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
                  Име на урока
                </th>
                <th>
                  Име на предмета
                </th>
                <th>
                  Клас
                </th>
                <th>
                  Създадено от
                </th>
                <th v-if="can('edit-lesson') || can('delete-lesson')">
                  Опции
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="lesson in lessons">
                <td>{{ lesson.name }}</td>
                <td>{{ lesson.subject.name }}</td>
                <td class="class-col">{{ lesson.class }}. Клас</td>
                <td>
                  <router-link tag="a" :to="{ name:'UserURL', params:{ id: lesson.user.id }}">
                    {{ lesson.user.name }}
                  </router-link>
                </td>
                <td v-if="can('edit-lesson') || can('delete-lesson')">
                  <div class='text-right'>
                    <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'EditLesson', params:{ id: lesson.id }}" v-if="can('edit-lesson')">
                      <i class="fa fa-edit"></i>
                      <span>Редактирай</span>
                    </router-link>
                    <button class="btn btn-danger btn-xs" @click="DeleteLesson(lesson.id)" v-if="can('delete-lesson')">
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
      lessons: [],
      lessonsIds: [],
      hasAlert: false,
      alert: {}
    }
  },

  beforeCreate () {
    this.$parent.isLoading = true
    this.$http.get('/api/lesson').then(
      (response) => {
        this.lessons = response.data
        this.lessonsIds = response.data.map(el => el.id)

        this.$parent.setDataTable()

        this.$parent.isLoading = false
      }, (error) => {
        console.log(error);
      }
    )

    this.$store.dispatch('reset_test')
  },

  components: {
    "alert": Alert
  },

  computed:{
    isAdmin(){
      return this.$store.getters.User.role == 'admin'
    },

    isTeacher(){
      return this.$store.getters.User.role == 'teacher'
    }
  },

  methods: {
    DeletePartition(id) {
      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.delete('/api/lesson/' + id).then((response) => {
        this.hasAlert = true

        console.log(response.data);

        this.alert = {
          type: 'alert-success',
          messages: response.data.success
        }

        const index = this.lessonsIds.indexOf(id)
        this.$parent.table.fnDestroy()

        this.lessons.splice(index, 1)
        this.lessonsIds.splice(index, 1)

        this.$parent.setDataTable()

        this.$parent.isLoading = false
      }, (error) => {
        console.error(error);
      })
    }
  }
}
</script>
