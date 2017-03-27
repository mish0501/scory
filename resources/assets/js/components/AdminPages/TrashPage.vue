<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-trash"></i>
        Кошче
      </h1>
    </div>

    <div class='box bordered-box purple-border' :class="[(subjects.length <= 0) ? 'box-collapsed' : '']" style='margin-bottom:0;' v-if="can('delete-subject')">
      <div class='box-header purple-background'>
        <div class='title'>
          <i class="fa fa-book"></i>
          <span v-if="subjects.length <= 0">
            Няма предмети в кошчето
          </span>
          <span v-else>
            Предмети в кошчето
          </span>
       </div>
       <div class='actions'>
         <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
       </div>
      </div>
      <div class='box bordered-box purple-border' style='margin-bottom:0;'>
        <div class='box-content'>
          <div class="responsive-table">
            <table class=' table table-bordered table-hover table-striped' style='margin-bottom:0;'>
              <thead>
                <tr>
                  <th>
                    Име на предмета
                  </th>
                  </th>
                  <th>
                    Клас
                  </th>
                  <th>
                    Опции
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="subject in subjects" v-if="subjects.length >= 0">
                  <td>{{ subject.name }}</td>
                  <td class="class-col">{{ subject.class }}. Клас</td>
                  <td>
                    <div class='text-right'>
                      <button class='btn btn-success btn-xs' @click="RenewSubject(subject.id)">
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                      <button class="btn btn-danger btn-xs" @click="DeleteSubject(subject.id)">
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
      <br>
    </div>

    <div class='box bordered-box blue-border' :class="[(partitions.length <= 0) ? 'box-collapsed' : '']" style='margin-bottom:0;' v-if="can('delete-partition')">
      <div class='box-header blue-background'>
        <div class='title'>
          <i class="fa fa-folder-open"></i>
          <span v-if="partitions.length <= 0">
           Няма раздели в кошчето
          </span>
          <span v-else>
            Раздели в кошчето
          </span>
       </div>
       <div class='actions'>
         <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
       </div>
      </div>
      <div class='box bordered-box purple-border' style='margin-bottom:0;'>
        <div class='box-content'>
          <div class="responsive-table">
            <table class=' table table-bordered table-hover table-striped' style='margin-bottom:0;'>
              <thead>
                <tr>
                  <th>
                    Име на раздела
                  </th>
                  <th>
                    Име на предмета
                  </th>
                  </th>
                  <th>
                    Клас
                  </th>
                  <th>
                    Опции
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="partition in partitions" v-if="partitions.length >= 0">
                  <td>{{ partition.name }}</td>
                  <td>{{ partition.subject.name }}</td>
                  <td class="class-col">{{ partition.class }}. Клас</td>
                  <td>
                    <div class='text-right'>
                      <button class='btn btn-success btn-xs' @click="RenewPartition(partition.id)">
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                      <button class="btn btn-danger btn-xs" @click="DeletePartition(partition.id)">
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
      <br>
    </div>

    <div class='box bordered-box green-border' :class="[(questions.length <= 0) ? 'box-collapsed' : '']" style='margin-bottom:0;' v-if="can('delete-question')">
      <div class='box-header green-background'>
        <div class='title'>
          <i class="fa fa-question"></i>
          <span v-if="questions.length <= 0">
           Няма въпроси в кошчето
          </span>
          <span v-else>
            Въпроси в кошчето
          </span>
       </div>
       <div class='actions'>
         <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
       </div>
      </div>
      <div class='box bordered-box purple-border' style='margin-bottom:0;'>
        <div class='box-content'>
          <div class="responsive-table">
            <table class=' table table-bordered table-hover table-striped' style='margin-bottom:0;'>
              <thead>
                <tr>
                  <th>
                    Име на въпроса
                  </th>
                  <th>
                    Име на раздела
                  </th>
                  <th>
                    Име на предмета
                  </th>
                  </th>
                  <th>
                    Клас
                  </th>
                  <th>
                    Опции
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="question in questions" v-if="questions.length >= 0">
                  <td>{{ question.name }}</td>
                  <td>{{ question.partition.name }}</td>
                  <td>{{ question.subject.name }}</td>
                  <td class="class-col">{{ question.class }}. Клас</td>
                  <td>
                    <div class='text-right'>
                      <button class='btn btn-success btn-xs' @click="RenewQuestion(question.id)">
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                      <button class="btn btn-danger btn-xs" @click="DeleteQuestion(question.id)">
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
      <br>
    </div>

    <div class='box bordered-box red-border' :class="[(testrooms.length <= 0) ? 'box-collapsed' : '']" style='margin-bottom:0;'>
      <div class='box-header red-background'>
        <div class='title'>
          <i class="fa fa-group"></i>
          <span v-if="testrooms.length <= 0">
           Няма стаи в кошчето
          </span>
          <span v-else>
            Стаи в кошчето
          </span>
       </div>
       <div class='actions'>
         <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
       </div>
      </div>
      <div class='box bordered-box purple-border' style='margin-bottom:0;'>
        <div class='box-content'>
          <div class="responsive-table">
            <table class=' table table-bordered table-hover table-striped' style='margin-bottom:0;'>
              <thead>
                <tr>
                  <th>
                    Код на стаята
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
                    Опции
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="room in testrooms"v-if="testrooms.length >= 0">
                  <td>{{ room.code }}</td>
                  <td>{{ room.subject.name }}</td>
                  <td>{{ room.partition.name }}</td>
                  <td class="class-col">{{ room.class }}. Клас</td>
                  <td>
                    <div class='text-right'>
                      <button class='btn btn-success btn-xs' @click="RenewTestroom(room.id, room.code)">
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                      <button class="btn btn-danger btn-xs" @click="DeleteTestroom(room.id, room.code)">
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
      <br>
    </div>

    <div class='box bordered-box orange-border' :class="[(mail.length <= 0) ? 'box-collapsed' : '']" style='margin-bottom:0;' v-if="can('delete-mail')">
      <div class='box-header orange-background'>
        <div class='title'>
          <i class="fa fa-group"></i>
          <span v-if="questions.length <= 0">
           Няма съобщения в кошчето
          </span>
          <span v-else>
            Съобщения в кошчето
          </span>
       </div>
       <div class='actions'>
         <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
       </div>
      </div>
      <div class='box bordered-box purple-border' style='margin-bottom:0;'>
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
                  <th>
                    Опции
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="message in mail" v-if="mail.length >= 0">
                  <td>{{ message.name }} ({{ message.email }})</td>
                  <td>{{ message.subject }}</td>
                  <td>{{ message.message }}</td>
                  <td>{{ isRead(message.read) }}</td>
                  <td>{{ message.time }}</td>
                  <td>
                    <div class='text-right'>
                      <button class='btn btn-success btn-xs' @click="RenewMail(message.id)">
                        <i class='fa fa-check'></i> Възтанови
                      </button>
                      <button class="btn btn-danger btn-xs" @click="DeleteMail(message.id)">
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
  </div>
</template>

<script>
export default {
  name:"Trash",
  data() {
    return{
      subjects: [],
      subjectsIds: [],
      partitions: [],
      partitionsIds: [],
      questions: [],
      questionsIds: [],
      testrooms: [],
      testroomsIds: [],
      mail: [],
      mailIds: []
    }
  },

  beforeCreate() {
    this.$parent.isLoading = true
    this.$http.get('/api/trash').then((response) => {
      const data = response.data

      this.subjects = data.subjects
      this.subjectsIds = data.subjects.map(el => el.id)

      this.partitions = data.partitions
      this.partitionsIds = data.partitions.map(el => el.id)

      this.questions = data.questions
      this.questionsIds = data.questions.map(el => el.id)

      this.testrooms = data.testrooms
      this.testroomsIds = data.testrooms.map(el => el.id)

      this.mail = data.mail
      this.mailIds = data.mail.map(el => el.id)

      this.$nextTick(() => {
        $('.table').dataTable({
          sPaginationType: "bootstrap",
          fnDrawCallback () {
            return $(".dataTables_wrapper").addClass("scrollable-area");
          }
        })
      })

      this.$parent.isLoading = false
    }, (error) => {
      console.error(error);
    })
  },

  computed: {
    isAdmin() {
      return this.$store.getters.User.role == 'admin'
    }
  },

  methods: {
    isRead(read){
      return (read) ? 'Прочетено' : 'Непрочетено'
    },

    DeleteSubject(id) {
      this.$parent.isLoading = false
      this.$http.delete('/api/trash/delete/subject/'+id).then((response) => {
        if(response.data.done){
          const index = this.subjectsIds.indexOf(id)
          this.subjects.splice(index, 1)
          this.subjectsIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    RenewSubject(id) {
      this.$parent.isLoading = true
      this.$http.post('/api/trash/renew/subject', { id }).then((response) => {
        if(response.data.done){
          const index = this.subjectsIds.indexOf(id)
          this.subjects.splice(index, 1)
          this.subjectsIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    DeletePartition(id) {
      this.$parent.isLoading = true
      this.$http.delete('/api/trash/delete/partition/'+id).then((response) => {
        if(response.data.done){
          const index = this.partitionsIds.indexOf(id)
          this.partitions.splice(index, 1)
          this.partitionsIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    RenewPartition(id) {
      this.$parent.isLoading = true
      this.$http.post('/api/trash/renew/partition', { id }).then((response) => {
        if(response.data.done){
          const index = this.partitionsIds.indexOf(id)
          this.partitions.splice(index, 1)
          this.partitionsIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    DeleteQuestion(id) {
      this.$parent.isLoading = true
      this.$http.delete('/api/trash/delete/question/'+id).then((response) => {
        if(response.data.done){
          const index = this.questionsIds.indexOf(id)
          this.question.splice(index, 1)
          this.questionsIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    RenewQuestion(id) {
      this.$parent.isLoading = true
      this.$http.post('/api/trash/renew/question', { id }).then((response) => {
        if(response.data.done){
          const index = this.questionsIds.indexOf(id)
          this.questions.splice(index, 1)
          this.questionsIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    DeleteTestroom(id, code) {
      this.$parent.isLoading = true
      this.$http.delete('/api/trash/delete/testroom/'+code).then((response) => {
        if(response.data.done){
          const index = this.testroomsIds.indexOf(id)
          this.testrooms.splice(index, 1)
          this.testroomsIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    RenewTestroom(id, code) {
      this.$parent.isLoading = true
      this.$http.post('/api/trash/renew/testroom', { code }).then((response) => {
        if(response.data.done){
          const index = this.testroomsIds.indexOf(id)
          this.testrooms.splice(index, 1)
          this.testroomsIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    DeleteMail(id) {
      this.$parent.isLoading = true
      this.$http.delete('/api/trash/delete/mail/'+id).then((response) => {
        if(response.data.done){
          const index = this.mailIds.indexOf(id)
          this.mail.splice(index, 1)
          this.mailIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },

    RenewMail(id) {
      this.$parent.isLoading = true
      this.$http.post('/api/trash/renew/mail', { id }).then((response) => {
        if(response.data.done){
          const index = this.mailIds.indexOf(id)
          this.mail.splice(index, 1)
          this.mailIds.splice(index, 1)
          this.$parent.isLoading = false
        }
      }, (error) => {
        console.error(error);
      })
    },
  }
}
</script>
