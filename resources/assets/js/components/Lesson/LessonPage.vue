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
      <div class="row" v-if="text">
        <div class="col-md-12" style="margin-bottom: 5px">
          <div class="tabs">
            <p>{{ text }}</p>
          </div>
        </div>
      </div>

      <div class="row" style="margin-top: 10px" v-if="files.length > 0">
        <files :files="files"></files>
      </div>
    </div>
  </div>
</template>

<script>
  import Files from "./Files.vue"

  export default {
    name: 'LessonPage',
    data() {
      return {
        title: "",
        text: "",
        files: [],
        isLoading: false
      }
    },

    components: {
      'files': Files
    },

    computed:{
      id () {
        return this.$route.params.id
      }
    },

    mounted() {
      this.isLoading = true

      this.$http.get('/api/lesson/'+this.id).then( (response) => {
        console.log(response.data);
        this.title = response.data.name
        this.text = response.data.text
        this.files = response.data.files
        this.isLoading = false
      }, console.error)
    }
  }
</script>
