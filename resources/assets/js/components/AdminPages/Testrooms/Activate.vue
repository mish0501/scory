<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-group"></i>
        Всички ученици в стая {{ code }}
      </h1>

      <div class='pull-right'>
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ name: 'StartTestroom', params: {code:code} }">
            <i class='icon-play'></i>
            Стартирай теста
          </router-link>
        </div>
      </div>
    </div>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <div class="responsive-table">
          <div class="scrollable-area">
            <table class='table table-bordered table-hover table-striped' style='margin-bottom:0;'>
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
                </tr>
              </thead>
              <tbody>
                <tr v-for="student in students" v-if="students">
                  <td>{{student.number}}</td>
                  <td>{{student.name}}</td>
                  <td>{{student.lastname}}</td>
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
  name: "ActiveTestRoom",
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
    this.$http.post('/api/testroom/active', {code: this.code}).then(
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
      }, console.error
    )



    Echo.private('testroom.'+this.code)
      .listen('StudentConnected', (e) => {
        const student = {
          number: e.number,
          name: e.name,
          lastname: e.lastname
        }

        this.students.push(student)

        $(".table").dataTable()._fnDraw()
      })
  }
}
</script>
