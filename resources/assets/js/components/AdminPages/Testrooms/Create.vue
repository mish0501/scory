<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-group"></i>
          Нова стая
      </h1>
    </div>

    <div class='box-content'>

      <alert :alert="alert" v-if="hasAlert"></alert>

      <form class="form form-horizontal" @submit.prevent="CreateTestroom">

        <div class='form-group'>
          <label class='col-md-2 control-label'>Код на стаята</label>
          <div class='col-md-5'>
            <input class='form-control' disabled placeholder='Код на стаята' type='text' v-model="code">
          </div>
          <div class='col-md-5'>
            <input class="btn btn-primary" style="margin-bottom:5px" value="Генерирай отново" type="button" @click.prevent="CodeGen">
          </div>
        </div>
        <div class='form-group'>
          <label class='col-md-2 control-label' for='class'>Клас</label>
          <div class='col-md-5'>
            <select-class @classSelected="classSelected"></select-class>
          </div>
        </div>
        <div class='form-group' v-if="subject != null">
          <label class='col-md-2 control-label'>Предмет</label>
          <div class='col-md-5'>
            <select-subject :subject-id="subject" @subjectSelected="subjectSelected"></select-subject>
          </div>
        </div>
        <div class='form-group' v-if="partition != null">
          <label class='col-md-2 control-label'>Раздел</label>
          <div class='col-md-5'>
            <select-partition :partition-id="partition" @partitionSelected="partitionSelected"></select-partition>
          </div>
        </div>
        <div class='form-group' v-if="questions.length > 0">
          <label class='col-md-2 control-label'>Въпроси</label>
          <div class='col-md-5'>
            <multiselect
            v-model="selectedQuestions"
            :options="questions"
            :multiple="true"
            :allow-empty="false"
            :close-on-select="false"
            placeholder="Търси въпроси"
            label="name"
            track-by="name"
            :selectLabel="'Натиснете Enter, за да изберете'"
            :selectedLabel="'Избран'"
            :deselectLabel="'Натиснете Enter, за да се премахне'"
            :hide-selected="true"
            :limit="1"
            :limitText="count => `и още ${count}`"
            >
            </multiselect>
          </div>
        </div>
        <div class='form-group' v-if="questions.length > 0">
          <div class='col-md-1 col-md-offset-2'>
            <input type="number" min="5" v-model="randomQuestion" step="1" class='form-control' :max="questions.length" />
          </div>
          <div class='col-md-4'>
            <input type="button" class="btn btn-primary" value="Избери произволни въпроси" @click="selectRandomQuestions">
          </div>
        </div>
        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="CreateTestroom">
                <i class='icon-save'></i>
                Запази
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Alert from "../../Alert.vue"
import SelectClass from "../../SelectInputs/SelectClass.vue"
import SelectSubject from "../../SelectInputs/SelectSubject.vue"
import SelectPartition from "../../SelectInputs/SelectPartition.vue"
import Multiselect from 'vue-multiselect'

export default {
  data () {
    return {
      code: "",
      subject: null,
      partition: null,
      alert: {},
      hasAlert: false,

      selectedQuestions: null,
      questions: [],
      randomQuestion: 5
    }
  },

  created() {
    this.CodeGen()
  },

  computed: {
    classes(){
      return this.$store.getters.Class
    },

    user(){
      return this.$store.getters.User
    }
  },

  components: {
    "alert": Alert,
    "select-class": SelectClass,
    "select-subject": SelectSubject,
    "select-partition": SelectPartition,
    'multiselect': Multiselect
  },

  methods: {
    classSelected(data){
      this.subject = data.subject
      this.partition = data.partition
    },

    subjectSelected(data){
      this.subject = data.subject
      this.partition = data.partition
    },

    partitionSelected(data){
      this.partition = data.partition

      this.getQuestions()
    },

    getQuestions() {
      const data = {
        class: this.classes,
        subject: this.subject,
        partition: this.partition
      }
      this.$http.post('/api/questionGenerate', data).then(
        (response) => {
          this.questions = response.data
        }, (error) => {
          console.error(error);
        }
      )
    },

    selectRandomQuestions() {
      let arr = this.randomArr(this.questions.length, this.randomQuestion)

      let selected = []

      for (var i = 0; i < arr.length; i++) {
        selected.push(this.questions[arr[i]])
      }

      this.selectedQuestions = selected
    },

    randomArr(size, count) {
      var randomArr = []

      while (randomArr.length < count) {
        var randomnumber = Math.floor(Math.random() * size);
        var found = false;

        for (var i = 0; i < randomArr.length; i++) {
          if(randomArr[i] == randomnumber){
            found = true;
            break;
          }
        }

        if (!found) {
          randomArr[randomArr.length] = randomnumber;
        }
      }

      return randomArr;
    },

    CreateTestroom() {
      var data = {
        code: this.code,
        teacher_id: this.user.id
      }

      if(this.classes > 0){
        data.class = this.classes
      }

      if(this.subject > 0){
        data.subject_id = this.subject
      }

      if(this.partition > 0){
        data.partition_id = this.partition
      }

      if(this.selectedQuestions){
        data.questions = this.selectedQuestions
      }

      this.hasAlert = false

      this.$http.post('/api/testroom', data).then( (response) => {
        data = response.data

        if(data.success){
          this.hasAlert = true

          this.alert = {
            type: 'alert-success',
            messages: response.data.success
          }
        }else if (data.error) {

          this.alert.type = 'alert-danger'
          this.alert.messages = []
          if (Object.keys(data.error).length > 1) {
            for(var messages in data.error){
              for(var message in data.error[messages]){
                this.alert.messages.push(data.error[messages][message])
              }
            }
          }else {
            for(var message in data.error){
              this.alert.messages = data.error[message][0]
            }
          }
          this.hasAlert = true
        }
      }, (error) => {
        console.log(error);
      })
    },

    CodeGen(){
      this.$http.post('/api/codeGenerate').then(
        (response) =>{
          this.code = response.data
        },(error) => {
          console.error(error);
        })
    }
  }
}
</script>

<style lang="css">
</style>
