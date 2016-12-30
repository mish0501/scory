<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-comments"></i>
        Преглед на съобщение
      </h1>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='col-md-10'>
        <div class="col-md-2">
          <label>Името на подателя</label>
        </div>
        <div class='col-md-3'>
          <span>{{ message.name }} ({{ message.email }})</span>
        </div>
      </div>
      <div class="col-md-6">
        <hr style="border-top: 1px solid #ccc">
      </div>
      <div class='col-md-10'>
        <label class='col-md-2'>Относно</label>
        <div class='col-md-5'>
          <span>{{ message.subject }}</span>
        </div>
      </div>
      <div class="col-md-6">
        <hr style="border-top: 1px solid #ccc">
      </div>
      <div class='col-md-10'>
        <label class='col-md-2'>Съобщение</label>
        <div class='col-md-5'>
          <span>{{ message.message }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      message: {
        name: 'asdad',
        email: 'asdasd',
        subject: 'asdasd',
        message: 'asdad'
      }
    }
  },

  created () {
    this.$http.get('/api/mail/' + this.id).then(
      (response) => {
        console.log(response.data)
        this.message = response.data
      }, console.error
    )
  },

  computed: {
    id() {
      return this.$route.params.id
    }
  }
}
</script>

<style lang="css">
</style>
