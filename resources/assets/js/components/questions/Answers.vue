<template lang="html">
<div class="row">
  <div class="col-md-12" v-if="type == 'multiple'">
    <div class='checkbox' v-for="answer in answers">
      <label class="tabs" :class="[(curentChecked.includes(answer.id)) ? 'checked' : '']">
        <input type='checkbox' class="checkbox-input" name="correct[]" value="{{ answer.id }}" v-on:change="checkboxChecked(answer.id)" > <h4>{{ answer.name }}</h4>
      </label>
    </div>
  </div>

  <div class="col-md-12" v-if="type == 'one'">
    <div class="radio" v-for="answer in answers">
      <label class="tabs" :class="[(curentChecked == answer.id) ? 'checked' : '']">
        <input type="radio" class="radio-input" name="correct" value="{{ answer.id }}" v-on:click="radioChecked(answer.id)" > <h4>{{ answer.name }}</h4>
      </label>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: [
    'type',
    'answers',
    'question_id',
    'clicks'
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

      this.clicks ++
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

      this.clicks ++
    }
  },

  computed: {
    curentChecked() {

      if (this.clicks || this.clicks == 0) {
        if(typeof(Storage) !== "undefined") {
            if (localStorage.questionsAnswers) {
              var questionsAnswers = JSON.parse(localStorage.questionsAnswers)
              if (questionsAnswers[this.question_id]) {
                return questionsAnswers[this.question_id]
              }else{
                if(this.type == 'one'){
                  return null
                }else if (this.type == 'multiple') {
                  return []
                }
              }
            } else {
              if(this.type == 'one'){
                return null
              }else if (this.type == 'multiple') {
                return []
              }
            }
        }
      }

    }
  }
}
</script>
