<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <h1 class="tabs">{{ question.name }}</h1>
      </div>
    </div>

    <br>

    <answers :type="question.type" :question_id="question.id" :clicks.sync="clicks" :answers="question.answers"></answers>
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
  }
}
</script>
