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

    <div class="container">
      <form class="form" autocomplete="off" v-on:submit.prevent="selectQuestions">
        <div class="form-group">
          <select-class class="tabs input-lg"></select-class>
        </div>

        <div class="form-group">
          <select-subject class="tabs input-lg" :subject.sync="subject" v-if="subject"></select-subject>
        </div>

        <div class="form-group">
          <select-partition class="tabs input-lg" :partition.sync="partition" v-if="partition"></select-partition>
        </div>

        <div class="form-group">
          <select class="form-control tabs input-lg" name="questionCount" v-model="questionCount" v-if="partition != 'default' && partition != null ">
            <option selected disabled value="0">Избери си броя на въпросите</option>
            <option value="3">3 Въпроса</option>
            <option value="5">5 Въпроса</option>
            <option value="10">10 Въпроса</option>
            <option value="15">15 Въпроса</option>
            <option value="20">20 Въпроса</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block" v-on:click.prevent="selectQuestions" v-if="questionCount != 0">Продължи напред</button>
      </form>
    </div>
  </div>
</template>

<script>
  import SelectClass from "./SelectInputs/SelectClass.vue"
  import SelectSubject from "./SelectInputs/SelectSubject.vue"
  import SelectPartition from "./SelectInputs/SelectPartition.vue"

  import { set_questions } from "../vuex/test/actions.js"
  import { Class } from "../vuex/test/getters.js"

  export default {
    data() {
      return {
        subject: null,
        partition: null,
        questionCount: 0
      }
    },

    components: {
      'select-class': SelectClass,
      'select-subject': SelectSubject,
      'select-partition': SelectPartition
    },

    computed:{
      title: function() {
        if(this.class === null){
          return "Избери си клас"
        }else if (this.subject === "default") {
          return "Избери си предмет"
        }else if (this.partition === "default") {
          return "Избери си раздел"
        }else if(this.partition != "default"){
          return "Избери си броя на въпросите и продължи напред"
        }
      }
    },

    vuex: {
      actions: {
        set_questions
      },

      getters: {
        class: Class
      }
    },

    methods: {
      selectQuestions: function () {
        var data = {
          'class': this.class,
          'subject_id': this.subject,
          'partition_id': this.partition,
          'questionCount': this.questionCount
        }

        this.$http.post("/questions", data).then((response) => {
          this.set_questions(response.data)
          localStorage.questions = JSON.stringify(response.data)
          this.$router.go({ name: 'TestPage'});
        }, (err) =>{
          console.log(err);
        })
      }
    }
  }
</script>
