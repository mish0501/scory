<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-book"></i>
        Всички въпроси
      </h1>

      <div class='pull-right' v-if="can('create-question')">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'question/create' }">
            <i class='fa fa-plus'></i>
            Добави въпрос
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
                  Име на въпроса
                </th>
                <th>
                  Име на предмета
                </th>
                <th>
                  Име на раздела
                </th>
                <th>
                  Име на потребителя
                </th>
                <th>
                  Клас
                </th>

                <th v-if="can('edit-question') || can('delete-question')">
                  Опции
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="question in questions">
                <td class="name"><span>{{ question.name }}</span></td>
                <td>{{ question.subject.name }}</td>
                <td>{{ question.partition.name }}</td>
                <td>
                  <router-link tag="a" :to="{ name:'UserURL', params:{ id: question.user.id }}">
                    {{ question.user.name }}
                  </router-link>
                </td>
                <td class="class-col">{{ question.class }}. Клас</td>
                <td v-if="can('edit-question') || can('delete-question')">
                  <div class='text-right'>
                      <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'EditQuestion', params:{ id: question.id }}" v-if="can('edit-question')">
                        <i class="fa fa-edit"></i>
                        <span>Редактирай</span>
                      </router-link>
                      <button class="btn btn-danger btn-xs" @click="DeleteQuestion(question.id)" v-if="can('delete-question')">
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
      questions: [],
      questionsIds: [],
      hasAlert: false,
      alert: {},
    }
  },

  components: {
    "alert": Alert
  },

  beforeCreate () {
    this.$parent.isLoading = true
    this.$http.get('/api/question').then(
      (response) => {
        this.questions = response.data
        this.questionsIds = response.data.map(el => el.id)

        this.$parent.setDataTable()

        this.$parent.isLoading = false
      }, (error) => {
        console.log(error);
      }
    )

    this.$store.dispatch('reset_test')
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
    DeleteQuestion(id) {
      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.delete('/api/question/' + id).then((response) => {
        this.hasAlert = true

        this.alert = {
          type: 'alert-success',
          messages: response.data.success
        }

        const index = this.questionsIds.indexOf(id)

        this.$parent.table.fnDestroy()

        this.questions.splice(index, 1)
        this.questionsIds.splice(index, 1)

        this.$parent.setDataTable()

        this.$parent.isLoading = false
      }, (error) => {
        console.error(error);
      })
    }
  }
}
</script>

<style lang="css">
td.name {
    max-width: 177px;
}
td.name span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    max-width: 100%;
}
</style>
