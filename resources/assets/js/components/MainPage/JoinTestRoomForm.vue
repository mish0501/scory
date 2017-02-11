<template>
  <form accept-charset="UTF-8" autocomplete="off" v-on:submit.prevent="joinTest">
    <div class="form-group">

      <div class="alert alert-danger" v-if="roomCodeError">
        <b>{{ roomCodeError}}</b>
            <p v-for="error in RCErrors">
              {{ error }}
            </p>
      </div>

      <label class="sr-only">Въведи кода на стаята</label>
      <input type="text" v-model="roomcode" name="roomcode" class="form-control input-lg" id="roomcode" placeholder="Въведи кода на стаята">
    </div>
    <div class="form-group">
      <button type="submit" v-on:click.prevent="joinTest" class="btn btn-success btn-lg btn-block">Влез в стаята</button>
    </div>
  </form>
</template>

<script>
export default {
  data () {
    return {
      roomcode: '',
      RCErrors: [],
      roomCodeError: ''
    }
  },
  methods: {
    joinTest: function() {
      this.$http.post('/join', { roomcode: this.roomcode }).then((response) => {
        this.RCErrors = [];
        this.roomCodeError = '';

        if(!response.data.redirect){
          this.RCErrors.push(response.data[0].roomcode[0]);
          this.roomCodeError = response.data['room_code_error'];
        }

        if(response.data.redirect){
          window.location.replace(response.data.url)
        }
      }, (err) => {
        console.log(err);
      });
    }
  }
}
</script>
