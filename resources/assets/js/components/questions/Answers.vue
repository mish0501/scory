<template lang="html">
  <div class="row">
    <div class="col-md-12" v-if="type == 'multiple' && !checked">
      <div class='checkbox' v-for="answer in answers">
        <label class="tabs" :class="[(curentChecked(answer.id)) ? 'checked' : '']">
          <input type='checkbox' class="checkbox-input" name="correct[]" v-bind:value="answer.id" v-on:change="checkboxChecked(answer.id)" > <h4>{{ answer.name }}</h4>
        </label>
      </div>
    </div>

    <div class="col-md-12" v-if="type == 'one' && !checked">
      <div class="radio" v-for="answer in answers">
        <label :class="[{ 'checked': curentChecked(answer.id) }, 'tabs']">
          {{ curentChecked(answer.id) }}
          <input type="radio" class="radio-input" name="correct" v-bind:value="answer.id" v-on:click="radioChecked(answer.id)" > <h4>{{ answer.name }}</h4>
        </label>
      </div>
    </div>

    <div class="col-md-12" v-if="checked">
      <div v-for="answer in answers">
        <h4 :class="['tabs', answer.correct ? 'true-answer' : 'false-answer']" v-if="answer.checked">{{ answer.name }}</h4>
        <h4 class="tabs" v-else>{{ answer.name }}</h4>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'type',
    'answers',
    'question_id'
  ],

  methods:{
    checkboxChecked(id) {
      if(typeof(Storage) !== "undefined") {
          if (localStorage.questionsAnswers) {
            var questionsAnswers = JSON.parse(localStorage.questionsAnswers)

            var curentQuestionAnswers = questionsAnswers[this.question_id]

            if(typeof(curentQuestionAnswers) !== "undefined"){
              if (curentQuestionAnswers.includes(id)){
                if(curentQuestionAnswers.length - 1 >= 1) {
                  this.removeAnswer(curentQuestionAnswers, id)
                }
              } else {
                curentQuestionAnswers.push(id)
              }
            }else{
              questionsAnswers[this.question_id] = [id]
            }

            localStorage.questionsAnswers = JSON.stringify(questionsAnswers)
          } else {
            var data = {}

            data[this.question_id] = [id]

            localStorage.questionsAnswers = JSON.stringify(data)
          }
      }
    },

    removeAnswer(arr) {
      var what, a = arguments, L = a.length, ax;
      while (L > 1 && arr.length) {
          what = a[--L];
          while ((ax= arr.indexOf(what)) !== -1) {
              arr.splice(ax, 1);
          }
      }
      return arr;
    },

    radioChecked(id) {
      if(typeof(Storage) !== "undefined") {
        if (localStorage.questionsAnswers) {
          var questionsAnswers = JSON.parse(localStorage.questionsAnswers)

          questionsAnswers[this.question_id] = id

          localStorage.questionsAnswers = JSON.stringify(questionsAnswers)
        } else {
          var data = {}

          data[this.question_id] = id

          localStorage.questionsAnswers = JSON.stringify(data)
        }
      }
    },

    curentChecked(id) {
      if(typeof(Storage) !== "undefined") {
        if (localStorage.questionsAnswers) {
          var questionsAnswers = JSON.parse(localStorage.questionsAnswers)

          if (questionsAnswers[this.question_id]) {
            if(this.type == 'one'){
              return questionsAnswers[this.question_id] == id
            }else if(this.type == 'multiple'){
              return questionsAnswers[this.question_id].includes(id)
            }
          }else{
            return false
          }
        } else {
          return false
        }
      }
    }
  },

  computed: {
    checked() {
      for (var i = 0, length = this.answers.length; i < length; i++) {
        if (this.answers[i].checked === true){
          return true
        }
      }

      return false
    }
  }
}
</script>
