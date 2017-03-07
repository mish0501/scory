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

    <div class="container" v-if="!lessons.length > 0">
      <form class="form" autocomplete="off" v-on:submit.prevent="selectQuestions">
        <div class="form-group">
          <select-class class="tabs input-lg" @classSelected="classSelected"></select-class>
        </div>

        <div class="form-group">
          <select-subject class="tabs input-lg" :subject-id="subject" v-if="subject != null" @subjectSelected="subjectSelected"></select-subject>
        </div>

        <button type="submit" class="btn btn-primary btn-lg btn-block" v-on:click.prevent="selectLessons" v-if="subject != null">Продължи напред</button>
      </form>
    </div>

    <div class="container" v-else>
      <div class="row">
        <div class="col-md-6" style="margin-bottom: 5px" v-for="lesson in lessons">
          <router-link :to="{ name:'LessonPage', params:{ id: lesson.id }}" class="tabs">{{ lesson.name }}</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import SelectClass from "../SelectInputs/SelectClass.vue"
  import SelectSubject from "../SelectInputs/SelectSubject.vue"

  export default {
    data() {
      return {
        subject: null,
        questionCount: null,
        title: "Избери си клас",
        isLoading: false
      }
    },

    components: {
      'select-class': SelectClass,
      'select-subject': SelectSubject
    },

    computed:{
      class () {
        return this.$store.getters.Class
      },

      lessons() {
        return this.$store.getters.Lessons
      }
    },

    methods: {
      classSelected(data){
        this.subject = null
        this.title = data.title
        this.questionCount = null
        this.subject = data.subject
      },

      subjectSelected(data){
        this.subject = data.subject
        this.partition = data.partition
        this.title = "Продължи напред"
        this.questionCount = null
      },

      selectLessons () {
        var data = {
          'class': this.class,
          'subject_id': this.subject
        }

        this.$http.post("/api/selectLessons", data).then((response) => {
          if(response.data.length > 0){
            this.$store.dispatch('set_lessons', response.data);
            this.title= "Избери си урок"
          }
        }, console.error)
      }
    }
  }
</script>
