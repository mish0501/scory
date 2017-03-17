<template lang="html">
  <div
    class="alert"
    role="alert"
    v-bind:class="[alert.type]"
    v-if="alert.messages"
  >
    <p v-if="isArray" v-for="message in alert.messages">
      {{message}}
    </p>

    <p v-if="!isArray">
      {{alert.messages}}
    </p>
  </div>
</template>

<script>
export default {
  computed: {
    isArray () {
      return typeof this.alert.messages === 'object'
    }
  },
  props: [
    'alert'
  ]
}
</script>
