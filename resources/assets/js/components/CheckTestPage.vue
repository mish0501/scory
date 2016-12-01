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
      <question :question="question" v-for="question in questions"></question>
    </div>
  </div>
</template>

<script>
import Question from "./questions/Question.vue"

export default {

  data() {
    return{
      questions: null
    }
  },

  components: {
    "question": Question
  },

  created(){
    if(typeof(Storage) !== "undefined") {
        if (localStorage.questions) {
          this.questions = JSON.parse(localStorage.questions)[0]
        } else {
          alert("За да можеш да видиш тази страница, трябва да си направил тест!")
          this.$router.go('/test/select');
        }
    } else {
        alert("Съжаляваме, но браузърът ви не подържа уеб хранилище");
    }
  }
}
</script>
