<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-group"></i>
        Всички готови ученици в стая {{ code }}
      </h1>

      <div class='pull-right'>
        <div class='btn-group'>
          <span class="btn" v-if="timer">
            <i class='fa fa-clock-o'></i>
            {{ timer }}
          </span>
          <a class="btn btn-success" @click.prevent="StopTest">
            <i class='fa fa-play'></i>
            Стоп на теста
          </a>
        </div>
      </div>
    </div>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <div class="responsive-table">
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
                      <i class='fa fa-question'></i>
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
</template>

<script>
export default {
  name: "TestRoomStart",
  data(){
    return{
      students: [],
      timer: '',
      table: {}
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

        this.$parent.setDataTable()

        this.getTime()

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

        this.$parent.table.fnDestroy()
        this.students.push(student)
        this.$parent.setDataTable()
      })
  },

  methods: {
    StopTest(){
      this.$http.get('/api/testroom/'+this.code+'/end').then(
        (response) => {
          if(response.data.success){
            this.$router.push({ name: 'ResultsTestroom', params:{ code: this.code}})
          }
        },(error) => {
          console.error(error);
        }
      )
    },

    startTimer(duration) {
      var timer = duration, minutes, seconds, interval;
      var vm = this
      var func = function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        if(--timer < 0){
          clearInterval(interval);
          vm.StopTest()
        }

        vm.timer = minutes + ":" + seconds
      }
      interval = setInterval(func, 1000);
    },
    getTime() {
      this.$http.post('/api/testroom/getTime', { code: this.code }).then(
        (response) => {
          let data = response.data
          let now = new Date()
          let testStarted = new Date(data.testStarted)

          let elapsedT = Math.floor((now - testStarted) / 1000)

          let timer = data.duration - elapsedT

          if(timer > 0){
            this.startTimer(timer)
          }
        }, console.error
      )
    }
  }
}
</script>
