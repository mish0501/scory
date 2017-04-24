<template>
  <div>
    <nav>
      <div class="container" >
        <div class="row">
          <div class="col-md-12 col-xs-12 text-center">
            <p class="title col-md-10 col-md-offset-1 col-xs-10">
             Моля изчакайте
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
      <div class="tabs" >
        Моля изчакайте, докато всички влязат в стаята и учителят пусне теста!
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    computed: {
      code(){
        return this.$route.params.code
      }
    },

    mounted() {
      Echo.channel('testroom.'+this.code)
        .listen('TestStart', (e) => {
          this.$router.push({ name:'Testroom', params: { code: this.code }})
        });

      if(typeof(Storage) !== "undefined") {
        if (localStorage.testroom) {
          let testroom = JSON.parse(localStorage.testroom)
          if(this.code != testroom.code){
            testroom.code = this.code

            localStorage.testroom = JSON.stringify(testroom)            
          }
        }else {
          let testroom = {
            'code': this.code
          }

          localStorage.testroom = JSON.stringify(testroom)
        }
      } else {
          alert("Съжаляваме, но браузърът ви не подържа уеб хранилище");
      }
    }
  }
</script>
