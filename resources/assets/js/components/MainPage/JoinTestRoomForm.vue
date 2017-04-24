<template>
  <div>
    <p class="text-center">
      Влязъл си като: <b>{{ user.name }}</b> | <a href="#" @click="logout()">Изход</a>
    </p>

    <form accept-charset="UTF-8" autocomplete="off" v-on:submit.prevent="joinTest" v-if="start">
      <div class="input-group">

        <div class="alert alert-danger" v-if="roomCodeError">
          <b>{{ roomCodeError}}</b>
              <p v-for="error in RCErrors">
                {{ error }}
              </p>
        </div>

        <label class="sr-only">Въведи кода на стаята</label>
        <input type="text" v-model="roomcode" name="roomcode" class="form-control input-lg" id="roomcode" placeholder="Въведи кода на стаята">
        <div class="input-group-btn">
          <button type="submit" v-on:click.prevent="joinTest" class="btn btn-danger btn-lg btn-block">Влез в стаята</button>
        </div>
      </div>
    </form>

    <form accept-charset="UTF-8" autocomplete="off" v-on:submit.prevent="joinTest" v-else>
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
        <button type="submit" v-on:click.prevent="joinTest" class="btn btn-danger btn-lg btn-block">Влез в стаята</button>
      </div>
    </form>
  </div>
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

  props:[
    'start',
  ],

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
  },

  computed: {
    user() {
      return this.$store.getters.User
    }
  }
}
</script>
