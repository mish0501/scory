<template>
  <div>
    <nav>
      <div class="container" >
        <div class="row">
          <div class="col-md-12 col-xs-12 text-center">
            <p class="title col-md-10 col-md-offset-1 col-xs-10">
              {{ title }}
            </p>

            <div class="text-right col-md-1 col-xs-1">
              <a href="/endtest">
                <i class="fa fa-times fa-3x icon"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <br><br><br>

    <loading v-if="isLoading"></loading>

    <div class="container">
      <form class="form" autocomplete="off" v-on:submit.prevent="selectQuestions">
        <div class="form-group">
          <select-class class="tabs input-lg" @classSelected="classSelected"></select-class>
        </div>

        <div class="form-group">
          <select-subject class="tabs input-lg" :subject-id="subject" v-if="subject != null" @subjectSelected="subjectSelected"></select-subject>
        </div>

        <div class="form-group">
          <select-partition class="tabs input-lg" :partition-id="partition" v-if="partition != null" @partitionSelected="partitionSelected"></select-partition>
        </div>

        <div class="form-group">
          <select class="form-control tabs input-lg" name="questionCount" v-model="questionCount" v-if="partition > 0 " v-on:change="ChangeTitle">
            <option disabled value="0">Избери си броя на въпросите</option>
            <option value="3">3 Въпроса</option>
            <option value="5">5 Въпроса</option>
            <option value="10">10 Въпроса</option>
            <option value="15">15 Въпроса</option>
            <option value="20">20 Въпроса</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block" v-on:click.prevent="selectQuestions" v-if="questionCount > 0">Продължи напред</button>
      </form>
    </div>
  </div>
</template>

<script>
  import SelectClass from "./SelectInputs/SelectClass.vue"
  import SelectSubject from "./SelectInputs/SelectSubject.vue"
  import SelectPartition from "./SelectInputs/SelectPartition.vue"

  export default {
    data() {
      return {
        subject: null,
        partition: null,
        questionCount: null,
        title: "Избери си клас",
        isLoading: false
      }
    },

    components: {
      'select-class': SelectClass,
      'select-subject': SelectSubject,
      'select-partition': SelectPartition
    },

    computed:{
      class () {
        return this.$store.getters.Class
      }
    },

    methods: {
      classSelected(data){
        this.subject = null
        this.partition = data.partition
        this.title = data.title
        this.questionCount = null
        this.subject = data.subject
      },

      subjectSelected(data){
        this.subject = data.subject
        this.partition = data.partition
        this.title = data.title
        this.questionCount = null
      },

      partitionSelected(data){
        this.partition = data.partition
        this.title = data.title
        this.questionCount = data.questionCount
      },

      ChangeTitle() {
        this.title = "Продължи напред"
      },

      selectQuestions: function () {
        var data = {
          'class': this.class,
          'subject_id': this.subject,
          'partition_id': this.partition,
          'questionCount': this.questionCount
        }

        this.$http.post("/api/selectQuestions", data).then((response) => {
          this.$store.dispatch('set_questions', response.data)
          localStorage.questions = JSON.stringify(response.data)
          localStorage.removeItem('questionsAnswers');
          this.$router.push({ name: 'TestPage'});
        }, (err) =>{
          console.log(err);
        })
      }
    }
  }
</script>
