<template>
  <div>
    <div :class="question.correct ? 'true' : 'false'" v-if="checkQuestion">
      <div class="row">
        <div class="col-md-12">
          <h1 class="tabs name">{{ question.name }}</h1>
        </div>
      </div>

      <br>

      <answers :type="question.type" :question_id="question.id" :clicks.sync="clicks" :answers="question.answers"></answers>

      <br>
      <br>
    </div>

    <div v-else>
      <div class="row">
        <div class="col-md-12">
          <h1 class="tabs name">{{ question.name }}</h1>
        </div>
      </div>

      <br>

      <answers :type="question.type" :question_id="question.id" :clicks.sync="clicks" :answers="question.answers"></answers>
    </div>
  </div>
</template>

<script>
import Answers from "./Answers.vue"

export default {
  props:[
    'question',
    'clicks'
  ],

  components: {
    "answers": Answers
  },

  computed: {
    checkQuestion(){
      return typeof(this.question.correct) !== 'undefined'
    }
  }
}
</script>
