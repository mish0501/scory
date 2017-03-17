<template lang="html">
  <div>
    <div v-for="answer, index in answers">
      <div class='form-group' v-if="index == 0">
        <label class='col-md-2 control-label'>Отговори</label>
        <div class='col-md-5'>
          <input class='form-control' placeholder='Въведете отговора' type='text' v-model="answer.name">
        </div>
        <div class='col-md-5 col-sm-1 col-xs-1'>
          <div class="checkmark" :class="[(answer.correct) ? 'checked' : '']">
            <label>
              <i class="fa fa-check"></i>
              <input type="checkbox" class="hide" @change="CheckAnswer(index)">
            </label>
          </div>
        </div>
      </div>
      <div class='form-group' v-else>
        <div class='col-md-5 col-md-offset-2'>
          <input class='form-control' placeholder='Въведете отговора' type='text' v-model="answer.name">
        </div>
        <div class='col-md-5 col-sm-1 col-xs-1'>
          <div class="checkmark" :class="[(answer.correct == 1) ? 'checked' : '']">
            <label>
              <i class="fa fa-check"></i>
              <input type="checkbox" class="hide" @change="CheckAnswer(index)">
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'answers'
  ],

  methods: {
    CheckAnswer(index) {
      const correct = this.answers[index].correct

      let count = 0
      for (var answer in this.answers) {
        if (this.answers[answer].correct){
          count++
        }
      }

      if(correct == 1) {
        if(count - 1 >= 1){
          this.answers[index].correct = false
        }
      }else if(correct == 0) {
        this.answers[index].correct = true
      }


      if(count > 1){
        return this.$parent.type = 'multiple'
      }

      this.$parent.type = 'one'
    }
  },

  mounted() {
    this.$parent.answers = this.answers
  }
}
</script>

<style lang="css">
  .checkmark{
    color: #eee;
    background-color: #ddd;
    border-radius: 50%;
    border: #ddd 5px solid;
    width: 28px;
    height: 28px;
    position: absolute;
    text-align: center;
    line-height: 19px;
    font-size: 14pt;
    margin-left: -20px;
    margin-top: 2px;
    cursor: pointer;
  }

  .checkmark label{
    cursor: pointer;
  }

  .checkmark.checked{
    color: #fff;
    background-color: #5daf2b;
    border: #5daf2b 5px solid;
  }
</style>
