<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-group"></i>
        Резултати на ученикът/чката {{student.name}} {{student.lastname}}
      </h1>
    </div>

    <div class="alert alert-info alert-dismissable" v-if="questions.length-1 >= 0">
      <a class="close" data-dismiss="alert" href="#">×</a>
      <h4>
        <i class="fa fa-info-sign"></i>
        Информация
      </h4>
      Натиснете върху въпроса, за да видите какви са отговорите на ученикът/чката.<br>
      Отговорите оцветени с зелено са верните отговори към въпроса, тези оцветени в червено са грешно посочените от ученикът/чката, а тези в синьо-зелено са вярно посочените от ученикът/чката.
    </div>

    <div class="alert alert-danger alert-dismissable" v-else>
      <a class="close" data-dismiss="alert" href="#">×</a>
      <h4>
        <i class="fa fa-remove-sign"></i>
        Информация
      </h4>
      Няма данни за отговорите на този ученик/чка.
    </div>

    <div class='accordion accordion-green panel-group' id='questions' style='margin-bottom:0;' v-if="questions.length-1 >= 0">
      <div class="panel panel-default" v-for="question in questions">
        <div class="panel-heading">
          <a class="accordion-toggle" data-parent="#questions" data-toggle="collapse" :href='"#" + question.id'>
            {{question.name}}
          </a>
        </div>
        <div class="panel-collapse collapse" :id="question.id">
          <div class="panel-body">
            <div class="well" :style="style(answer)" v-for="answer in question.answers">{{ answer.name }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      student: {},
      questions: {}
    }
  },

  mounted() {
    this.$parent.isLoading = true
    this.$http.get('/api/testroom/'+this.code+'/student/'+this.number).then(
      (response) => {
        this.student = response.data.student
        this.questions = response.data.questions

        this.$parent.isLoading = false
      },(error) => {
        console.error(error);
      }
    )
  },

  computed: {
    code(){
      return this.$route.params.code
    },

    number() {
      return this.$route.params.number
    }
  },

  methods: {
    style(answer) {
      if(answer.checked){
        if(answer.correct){
          return {
            "background-color": "aquamarine"
          }
        }else{
          return {
            "background-color":"red",
            "color":"whitesmoke"
          }
        }
      }else if (answer.correct) {
        return {
          "background-color":"green",
          "color":"whitesmoke"
        }
      }
    }
  }
}
</script>
