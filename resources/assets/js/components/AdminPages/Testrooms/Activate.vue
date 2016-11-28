<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-group"></i>
        Всички стаи
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
        <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
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
</template>

<script>
export default {
  data(){
    return{
      code:null,
      students: []
    }
  },

  mounted(){
    this.code = this.$route.params.code

    this.$http.post('/api/testroom/active', {code: this.code}).then(
      (response) => {
        this.students = response.data.students
      }, (error) => {
        console.error(error);
      }
    )
  }
}
</script>

<style lang="css">
</style>
