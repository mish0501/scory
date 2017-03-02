<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-file"></i>
        Добави урок
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box-content'>
      <form class="form form-horizontal" @submit.prevent="CreateLesson">
        <div class='form-group'>
          <label class='col-md-2 control-label' for='name'>Име на урока</label>
          <div class='col-md-5'>
            <input class='form-control' placeholder='Въведете името на урока' type='text' v-model="name">
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
        <div class='form-group'>
          <label class='col-md-2 control-label'>Текст</label>
          <div class='col-md-5'>
            <textarea class="form-control" placeholder="Въведете текста на урока(не е задължително)" v-model="text" rows="8" cols="80"></textarea>
          </div>
        </div>

        <div class='form-group'>
          <label class='col-md-2 control-label'>Файлове към урока</label>
          <div class='col-md-2'>
            <button type="button" class="btn btn-info" @click="openFileManager">
              <i class='fa fa-files-o'></i>
              Избери файлове
            </button>
          </div>
        </div>

        <div class="form-group" v-if="files.length > 0">
          <div class="col-md-12">
            <div class="row" v-for="(file, index) in files">
              <div class="col-md-5 col-md-offset-2">
                <div>
                  <div class="col-md-8 col-sm-8 col-xs-10 name">
                    <span>
                      {{ file.name }}
                    </span>
                  </div>
                  <button type="button" class="btn btn-danger col-md-4 col-sm-4 col-xs-2" @click="removeFile(index)">
                    <i class='fa fa-remove'></i>
                    <span class="hidden-xs">Премахни</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class='form-actions form-actions-padding-sm'>
          <div class='row'>
            <div class='col-md-10 col-md-offset-2'>
              <button class='btn btn-primary' @click.prevent="CreateLesson">
                <i class='fa fa-save'></i>
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

export default {
  name: "LessonsCreate",
  data () {
    return {
      name: "",
      alert: {},
      subject: null,
      partition: null,
      hasAlert: false,
      isLoading: false,
      text: "",
      files: []
    }
  },

  watch: {
    isLoading (newValue) {
      this.$parent.isLoading = newValue
    }
  },

  computed: {
    id(){
      return this.$route.params.id
    },

    classes(){
      return this.$store.getters.Class
    },
  },

  components: {
    "alert": Alert,
    "select-class": SelectClass,
    "select-subject": SelectSubject,
    "select-partition": SelectPartition
  },

  created() {
    this.$parent.isLoading = true
    this.$http.get('/api/lesson/' + this.id + '/edit').then((response) => {
      let data = response.data
      let lesson = data.lesson

      this.name = lesson.name
      this.subject = lesson.subject_id
      this.partition = lesson.partition_id
      this.text = lesson.text

      for (var i = 0; i < lesson.files.length; i++) {
        let file = {
          id: lesson.files[i].id,
          name: lesson.files[i].data.name
        }
        this.files.push(file)
      }

      this.classes = data.class
      this.$store.dispatch('set_class', lesson.class)
      this.$store.dispatch('set_subjects', data.subjects)
      this.$store.dispatch('set_partitions', data.partitions)
      this.$parent.isLoading = false
    }, (error) => {
      console.error(error);
    })
  },

  mounted() {
    $(window).on('message', this.onMessage)
  },

  destroyed () {
    $(window).off('message', this.onMessage)
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
    },

    removeFile (index) {
      this.files.splice(index, 1)
    },

    CreateLesson() {
      var data = {
        name: this.name,
        subject_id: this.subject,
        partition_id: this.partition,
        text: this.text,
        files: this.files,
      }

      if(this.classes != 0){
        data.class = this.classes
      }

      this.hasAlert=false
      this.$parent.isLoading = true

      this.$http.post('/api/lesson', data).then( (response) => {
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
        this.$parent.isLoading = false
      }, console.error)
    },

    onMessage (e) {
      const data = e.originalEvent.data

      if (!data.files) {
        return
      }

      this.files = data.files
    },

    openFileManager () {
      let width = parseInt((window.screen.width * 80) / 100, 10)
      let height = parseInt((window.screen.height * 70) / 100, 10)

      if (width < 640) {
        width = 640
      }

      if (height < 420) {
        height = 420
      }

      const top = parseInt((window.screen.height - height) / 2, 10)
      const left = parseInt((window.screen.width - width) / 2, 10)

      const options = `location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes,width=${width},height=${height},top=${top},left=${left}`
      let FileManager = window.open('/file/manager', null, options)

      FileManager.fileCount = 'many'
      FileManager.files = this.files
    }
  }
}
</script>

<style lang="css">
div.name span {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: inline-block;
  max-width: 100%;
  line-height: 30px;
  margin-bottom: 10px
}
</style>
