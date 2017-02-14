<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-group"></i>
        Всички готови ученици в стая {{ code }}
      </h1>

      <div class='pull-right'>
        <div class='btn-group'>
          <a class="btn btn-success" @click.prevent="StopTest">
            <i class='icon-play'></i>
            Стоп на теста
          </a>
        </div>
      </div>
    </div>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <div class="responsive-table">
          <div class="scrollable-area">
            <table class=' table table-bordered table-hover table-striped' style='margin-bottom:0;'>
              <thead>
                <tr>
                  <th>
                    Номер в стаята
                  </th>
                  <th>
                    Име на ученика
                  </th>
                  <th>
                    Фамилия на ученика
                  </th>
                  <th>
                    Брой точки
                  </th>
                  <th>
                    Отговорите на ученика
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="student in students" v-if="students">
                  <td>{{student.number}}</td>
                  <td>{{student.name}}</td>
                  <td>{{student.lastname}}</td>
                  <td>{{student.correct}}</td>
                  <td>
                    <div class="text-right">
                      <router-link class='btn btn-success btn-xs' :to="{ name: 'StudentResultsTestroom', params: { code: code, number: student.number}}">
                        <i class='icon-question'></i>
                        <span>Покажи отговорите на ученика</span>
                      </router-link>
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
  data(){
    return{
      students: []
    }
  },

  computed: {
    code() {
      return this.$route.params.code
    }
  },

  mounted(){
    this.$parent.isLoading = true
    this.$http.post('/api/testroom/start', {code: this.code}).then(
      (response) => {
        this.students = response.data.students

        this.$nextTick(() => {
          $(".table").dataTable({
            sPaginationType: "bootstrap",
            fnDrawCallback () {
              return $(".dataTables_wrapper").addClass("scrollable-area");
            }
          })
        })

        this.$parent.isLoading = false
      },console.error
    )

    Echo.private('testroom.'+this.code)
      .listen('FinishTest', (e) => {
        const student = {
          name: e.name,
          lastname: e.lastname,
          number: e.number,
          correct: e.correct
        }

        this.students.push(student)
        $(".table").dataTable()._fnDraw()
      })
  },

  methods: {
    StopTest(){
      this.$http.get('/api/testroom/'+this.code+'/end').then(
        (response) => {
          if(response.data.success){
            this.$router.push('/admin/testroom')
          }
        },(error) => {
          console.error(error);
        }
      )
    }
  }
}
</script>

<style lang="css">
</style>
