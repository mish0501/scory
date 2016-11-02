<template>
  <div>
    <nav>
      <div class="container">
        <div class="row">
          <div class="pull-right text-right col-md-1">
            <a href="/endtest"><i class="fa fa-times fa-3x"></i></a>
          </div>
        </div>
      </div>
    </nav>

    <br>

    <div class="container">
      <question :question="questions[activeQuestion]" :clicks.sync="clicks"></question>

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
import { set_questions } from "../vuex/test/actions.js"
import { Questions } from "../vuex/test/getters.js"
import Question from "./questions/Question.vue"

export default {
  vuex: {
    getters: {
      questions: Questions
    },

    actions:{
      set_questions
    }
  },

  data() {
    return{
      activeQuestion: 0,
      nextQuestion: 1,
      previousQuestion: -1,
      clicks: 0
    }
  },

  components: {
    "question": Question
  },

  created(){
    if(typeof(Storage) !== "undefined") {
        if (localStorage.questions) {
            this.set_questions(JSON.parse(localStorage.questions))
        } else {
            localStorage.questions = JSON.stringify(this.questions)
        }
    } else {
        alert("Съжаляваме, но браузърът ви не подържа уеб хранилище");
    }
  },

  methods: {
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

    postTest() {

      let data = {}

      if(typeof(Storage) !== "undefined") {
          if (localStorage.questions && localStorage.questionsAnswers) {

            const questions = JSON.parse(localStorage.questions)
            const answers = JSON.parse(localStorage.questionsAnswers)

            data = {
              questions: questions,
              answers: answers
            }

          } else {
            this.previousQuestion = -1
            this.activeQuestion = 0
            this.nextQuestion = 1

            alert("Трябва да отговориш на всички въпроси.");
            return;
          }
      } else {
        alert("Съжаляваме, но браузърът ви не подържа уеб хранилище");
        return;
      }

      this.$http.post('/api/test/check', data).then(response => {
        localStorage.questions = JSON.stringify(response.data)
        localStorage.removeItem('questionsAnswers')

        this.$router.go('/test/check')
      }, error => {
        console.log(error);
      })
    }
  }
}
</script>
