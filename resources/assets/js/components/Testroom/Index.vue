<template lang="html">
  <div>
    <nav>
      <div class="container">
        <div class="row">
          <div class="col-md-2" v-if="time">
            <span class="timer">{{ time }}</span>
          </div>
          <div class="pull-right text-right col-md-1">
            <a href="/endtest"><i class="fa fa-times fa-3x"></i></a>
          </div>
        </div>
      </div>
    </nav>

    <br>

    <div class="container">
      <question :question="questions[activeQuestion]" v-if="gotQuestions"></question>

      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <button :disabled="previousQuestion < 0" class="btn btn-primary btn-lg btn-block" v-on:click.prevent="changePreviousQuestion()">Предишен <span class="hidden-xs">въпрос</span></button>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-6" v-if="activeQuestion != (questions.length - 1)">
            <button class="btn btn-primary btn-lg btn-block" v-on:click.prevent="changeNextQuestion()">Следващ <span class="hidden-xs">въпрос</span></button>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-6" v-if="activeQuestion == (questions.length - 1)">
            <button class="btn btn-success btn-lg btn-block" v-on:click.prevent="postTest()">Предай <span class="hidden-xs">теста</span></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Question from "../questions/Question.vue"

export default {
  name: "TestRoomTestPage",
  data() {
    return{
      activeQuestion: 0,
      nextQuestion: 1,
      previousQuestion: -1,
      gotQuestions: false,
      time: '',
      interval: 0
    }
  },

  components: {
    "question": Question
  },

  created() {
    this.$http.post('/api/testroom/getTime', { code: this.code }).then(
      (response) => {
        let data = response.data

        if(data.duration > 0){
          let now = new Date()
          let testStarted = new Date(data.testStarted)

          let elapsedT = Math.floor((now - testStarted) / 1000)

          let timer = data.duration - elapsedT

          if(timer > 0) {
            this.startTimer(timer)
          }
        }
      }, console.error
    )

    if(typeof(Storage) !== "undefined") {
        if (localStorage.testroom) {
          const testroom = JSON.parse(localStorage.testroom)
          if(this.code == testroom.code){
            if(testroom.questions){
              this.$store.dispatch('set_questions', testroom.questions)
              this.gotQuestions = true
            }else {
              this.$http.post('/api/testroom/getQuestions', {code:this.code}).then(
                (response) => {
                  this.$store.dispatch('set_questions', response.data.questions)
                  testroom.questions = response.data.questions
                  this.gotQuestions = true

                  localStorage.testroom = JSON.stringify(testroom)
                }, (error) => {
                  console.error(error);
                }
              )
            }
          }
        }else {
          let testroom = {
            'code': this.code
          }

          this.$http.post('/api/testroom/getQuestions', {code:this.code}).then(
            (response) => {
              this.$store.dispatch('set_questions', response.data.questions)
              testroom.questions = response.data.questions
              this.gotQuestions = true

              localStorage.testroom = JSON.stringify(testroom)
            }, (error) => {
              console.error(error);
            }
          )
        }
    } else {
        alert("Съжаляваме, но браузърът ви не подържа уеб хранилище");
    }
  },

  mounted() {
    Echo.channel('testroom.'+this.code)
      .listen('EndTest', (e) => {
        clearInterval(this.interval)
        this.postTest(true)
      });
      
    this.$http.get('/api/user').then((response) => {
      this.$store.dispatch('set_user', response.data)
    }, console.error)
  },

  computed: {
    code(){
      return this.$route.params.code
    },

    questions() {
      return this.$store.getters.Questions
    },

    user() {
      return this.$store.getters.User
    }
  },

  methods: {
    startTimer(duration) {
      var timer = duration, minutes, seconds;
      var vm = this
      var func = function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        vm.time = minutes + ":" + seconds

        timer--
      }
      let interval = setInterval(func, 1000);
      this.interval = interval
    },

    changeNextQuestion() {
      this.previousQuestion = this.activeQuestion
      this.activeQuestion = this.nextQuestion
      this.nextQuestion = this.activeQuestion + 1
    },

    changePreviousQuestion() {
      this.nextQuestion = this.activeQuestion
      this.activeQuestion = this.previousQuestion
      this.previousQuestion = this.activeQuestion - 1
    },

    postTest(skip) {
      let data = {
        code: this.code,
        testroom: true
      }

      if(typeof(Storage) !== "undefined") {
        if (localStorage.testroom) {
          const testroom = JSON.parse(localStorage.testroom)
          if(testroom.code == this.code){
            data.user= this.user.id
            data.questions = testroom.questions
          }
        }

        if (localStorage.questionsAnswers) {

          const answers = JSON.parse(localStorage.questionsAnswers)

          data.answers= answers

        } else {
          if (skip) {
            data.answers = []
          }else{
            this.previousQuestion = -1
            this.activeQuestion = 0
            this.nextQuestion = 1

            alert("Трябва да отговориш на всички въпроси.");
            return;
          }
        }
      } else {
        alert("Съжаляваме, но браузърът ви не подържа уеб хранилище");
        return;
      }

      this.$http.post('/api/test/check', data).then(
        (response) => {
          if(response.data.success){
            localStorage.removeItem('testroom')
            localStorage.removeItem('questionsAnswers')

            this.$router.push('/testroom/finish')
          }
        },(error) => {
          console.error(error);
        }
      )
    }
  }
}
</script>
