<template>
  <div>
    <div class="alert alert-success col-md-6 col-md-offset-3" v-if="inviteEmailSuccess">
        {{ inviteEmailSuccess }}
    </div>

    <div class="alert alert-danger col-md-6 col-md-offset-3" v-if="inviteEmailError">
      <p v-for="error in inviteEmailErorrs">
        {{ error }}
      </p>
    </div>

    <form accept-charset="UTF-8" autocomplete="off" class="col-md-12" v-on:submit.prevent="inviteEmailSubmit">
      <div class="input-group">
        <input type="email" class="form-control input-lg" name="invite-email" v-model="inviteEmail" placeholder="E-mail">
        <div class="input-group-btn">
          <button type="submit" v-on:click.prevent="inviteEmailSubmit" class="btn btn-danger btn-lg btn-block">Изпрати</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data () {
    return {
      inviteEmailErorrs: [],
      inviteEmailError: false,
      inviteEmailSuccess: '',
      inviteEmail: ''
    }
  },

  methods: {
    inviteEmailSubmit: function() {
      this.$http.post('/invite', { inviteEmail: this.inviteEmail }).then((response) => {
        this.inviteEmailErorrs = [];
        this.inviteEmailError = false;
        this.inviteEmailSuccess = '';

        if(!response.data.success){
          this.inviteEmailErorrs.push(response.data[0].inviteEmail[0]);
          this.inviteEmailError = true;
        }else{
          this.inviteEmailSuccess = response.data.invite_email;
        }
      }, (err) => {
        console.log(err);
      });
    }
  }
}
</script>

<style lang="css">
</style>
