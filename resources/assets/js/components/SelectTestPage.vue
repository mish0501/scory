<template>
  <div>
    <nav>
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 text-center">
            <p class="title">
              {{ title }}
            </p>
          </div>
          <div class="pull-right text-center col-md-1">
            <a href="/endtest"><i class="fa fa-times fa-3x"></i></a>
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
          <select-subject class="tabs input-lg" :subjects="subjects" :subject="subject" :class="class" v-if="subjects"></select-subject>
        </div>

        <div class="form-group">
          <select-partition class="tabs input-lg" :partitions="partitions" :partition="partition" v-if="partitions"></select-partition>
        </div>

        <div class="form-group">
          <select class="form-control tabs input-lg" name="questionCount" v-model="questionCount" v-if="partition != 'default'">
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

  export default {
    data() {
      return {
        class: null,
        subject: "default",
        subjects: null,
        partition: "default",
        partitions: null,
        questionCount: "0"
      }
    },

    components: {
      'select-class': SelectClass,
      'select-subject': SelectSubject,
      'select-partition': SelectPartition
    },

    ready(){
      this.$on('classSelected', function (data) {
        this.class = data.class
        this.subjects = data.subjects
        this.subject = "default"
        this.partition = "default"
        this.partitions = null
      });

      this.$on('subjectSelected', function (data) {
        this.subject = data.subject
        this.partitions = data.partitions
        this.partition = "default"
      });

      this.$on('partitionSelected', function (data) {
        this.partition = data.partition
      });
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
          return "Избери си броя на въпросите"
        }else if(this.questionCount){
          return "Продължи напред"
        }
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
          this.emit('questions', response.data)
          this.$router.go('/test');
        }, (err) =>{
          console.log(err);
        })
      }
    }
  }
</script>
