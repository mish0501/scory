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
      <form class="form" autocomplete="off" v-on:submit.prevent="JoinStudent" v-if="!wait">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="tabs">
              <input type="text" name="name" placeholder="Име" v-model="name">
            </div>
            <br>
            <div class="tabs">
              <input type="text" name="lastname" placeholder="Фамилия" v-model="lastname">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-6 col-md-offset-3 submit">
            <button type="submit" class="btn btn-primary btn-lg btn-block" v-on:click.prevent="JoinStudent">Продължи напред</button>
          </div>
        </div>
      </form>

      <div class="tabs" v-if="wait">
        {{ waitMsg }}
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        name: "",
        lastname: "",
        title: "Въведи си името и фамилията",
        wait: false,
        waitMsg: ""
      }
    },

    methods: {
      JoinStudent(){
        const data = {
          code: this.$route.params.code
        }

        if(this.name !== ""){
          data.name = this.name
        }

        if(this.lastname !== ""){
          data.lastname = this.lastname
        }

        this.$http.post('/api/connect', data).then(
          (response) => {
            if(!response.data.testStarted){
              this.wait = true
              this.waitMsg = "Моля изчакайте, докато всички влязат в стаята и учителят пусне теста!"
              this.title = "Моля изчакайте"
            }
          },(error) => {
            console.error(error);
          }
        )
      }
    }
  }
</script>
