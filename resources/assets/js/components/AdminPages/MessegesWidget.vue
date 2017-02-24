<template lang="html">
  <li class='dropdown medium only-icon widget'>
    <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
      <i class='fa fa-comments'></i>
      <div class='label'>{{ (messageCount != 0) ? messageCount : '' }}</div>
    </a>
    <ul class='dropdown-menu'>

      <li v-for="message in messages">
        <a :href="message.url">
          <div class="widget-body">
            <div class="pull-left icon"><i class="fa fa-comments text-success"></i></div>
            <div class="pull-left text">{{ message.name }} изпрати съобщение <small class="text-muted">{{ message.time }}</small></div>
          </div>
        </a>
      </li>


      <li class="widget-footer">
        <router-link tag="a" :to="{ path: '/admin/mail' }">Всички съобщения</a>
      </li>
    </ul>
  </li>
</template>

<script>
export default {
  data () {
    return {
      messageCount: 0,
      messages: []
    }
  },

  methods: {
    loadMessages() {
      this.$http.post('/api/getAllMessages').then(
        (response) => {
          this.messageCount = response.data.count
          this.messages = response.data.messages
        }, (error) => {
          console.error(error);
        }
      )
    }
  },

  created(){
    this.loadMessages()

    Echo.private('MailChannel')
      .listen('NewMail', (e) => {
        if(e.new_mail) {
          this.loadMessages()
        }
      })
      .listen('MessageOpened', (e) => {
        if(e.message_opened) {
          if(this.messageCount > 0) {
            this.messageCount -= 1
          }
        }
      })
  }
}
</script>

<style lang="css">
</style>
