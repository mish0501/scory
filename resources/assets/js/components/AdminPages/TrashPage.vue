<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-trash"></i>
        Кошче
      </h1>
    </div>

    <div class='box bordered-box purple-border' :class="[(subjects.length <= 0) ? 'box-collapsed' : '']" style='margin-bottom:0;'>
      <div class='box-header purple-background'>
        <div class='title'>
          <i class="icon-book"></i>
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
          <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
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
              <tr v-for="subject in subjects">
                <td>{{ subject.name }}</td>
                <td class="class-col">{{ subject.class }}. Клас</td>
                <td>
                  <div class='text-right'>
                    <button class='btn btn-success btn-xs' @click="RenewSubject(subject.id)">
                      <i class='icon-check'></i> Възтанови
                    </button>
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
    <br>
    <div class='box bordered-box blue-border' :class="[(partitions.length <= 0) ? 'box-collapsed' : '']" style='margin-bottom:0;'>
      <div class='box-header blue-background'>
        <div class='title'>
          <i class="icon-book"></i>
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
          <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
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
              <tr v-for="partition in partitions">
                <td>{{ partition.name }}</td>
                <td>{{ partition.subject.name }}</td>
                <td class="class-col">{{ partition.class }}. Клас</td>
                <td>
                  <div class='text-right'>
                    <button class='btn btn-success btn-xs' @click="RenewPartition(partition.id)">
                      <i class='icon-check'></i> Възтанови
                    </button>
                    <button class="btn btn-danger btn-xs" @click="DeletePartition(partition.id)">
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
    <br>
    <div class='box bordered-box green-border' :class="[(questions.length <= 0) ? 'box-collapsed' : '']" style='margin-bottom:0;'>
      <div class='box-header green-background'>
        <div class='title'>
          <i class="icon-book"></i>
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
          <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
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
              <tr v-for="question in questions">
                <td>{{ question.name }}</td>
                <td>{{ question.partition.name }}</td>
                <td>{{ question.subject.name }}</td>
                <td class="class-col">{{ question.class }}. Клас</td>
                <td>
                  <div class='text-right'>
                    <button class='btn btn-success btn-xs' @click="RenewPartition(question.id)">
                      <i class='icon-check'></i> Възтанови
                    </button>
                    <button class="btn btn-danger btn-xs" @click="DeletePartition(question.id)">
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
  </div>
</template>

<script>
export default {
  data() {
    return{
      subjects: [],
      subjectsIds: [],
      partitions: [],
      partitionsIds: [],
      questions: [],
      questionsIds: []
    }
  },

  mounted() {
    this.$http.get('/api/trash').then((response) => {
      console.log(response);

      const data = response.data

      this.subjects = data.subjects
      this.subjectsIds = data.subjects.map(el => el.id)

      this.partitions = data.partitions
      this.partitionsIds = data.partitions.map(el => el.id)

      this.questions = data.questions
      this.questionsIds = data.questions.map(el => el.id)
    }, (error) => {
      console.error(error);
    })
  },

  methods: {
    DeleteSubject(id) {
      this.$http.delete('/api/trash/delete/subject/'+id).then((response) => {
        console.log(response);
      }, (error) => {
        console.error(error);
      })
    },

    RenewSubject() {

    }
  }
}
</script>

<style lang="css">
</style>
