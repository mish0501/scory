<template>
  <div>
    <div class="alert alert-success" v-if="messageSuccess">
      {{ messageSuccess }}
    </div>

    <div class="alert alert-danger" v-if="messageError">
      <p v-for="error in messageErrors[0]">
        {{ error }}
      </p>
    </div>

    <form class="form-horizontal" v-on:submit.prevent="messegeSend" accept-charset="UTF-8" autocomplete="off">
      <div class="form-group">
        <div class="col-xs-6">
          <input type="text" class="form-control input-lg" name="first_name" placeholder="Име" v-model="firstName">
        </div>
        <div class="col-xs-6 pull-right">
          <input type="text" class="form-control input-lg" name="last_name" placeholder="Фамилия" v-model="lastName">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12">
          <input type="email" class="form-control input-lg" name="email" placeholder="Email" v-model="email">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12">
          <input type="text" class="form-control input-lg" name="subject" placeholder="Относно" v-model="subject">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12">
          <textarea class="form-control input-lg" rows="7" name="message" placeholder="Съобщение" v-model="message"></textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-2">
          <button type="submit" v-on:click.prevent="messegeSend" class="btn btn-success btn-lg btn-block">Изпрати</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data () {
    return {
        inviteEmail: '',
        firstName: '',
        lastName: '',
        email: '',
        subject: '',
        message: '',
        messageSuccess: '',
        messageError: false,
        messageErrors: []
    }
  },

  methods: {
    messegeSend: function(){
      var mail = {
        'first_name': this.firstName,
        'last_name': this.lastName,
        'email': this.email,
        'subject': this.subject,
        'message': this.message
      }

      this.$http.post('/contact', mail).then((response) => {
        this.messageErrors = [];
        this.messageSuccess = '';
        this.messageError = false;

        if(!response.data.success){
          this.messageErrors.push(JSON.parse(response.data[0]));
          this.messageError = true;
        }else{
          this.messageSuccess = response.data.mailSend;

          this.firstName= '';
          this.lastName= '';
          this.email= '';
          this.subject= '';
          this.message= '';
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
