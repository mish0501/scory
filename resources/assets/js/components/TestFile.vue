<template lang="html">
  <button type="button" class="btn btn-primary" @click="openFileManager">Файлов Мениджър</button>
</template>

<script>
export default {
  data () {
    return {
      selectedFiles: []
    }
  },

  created () {
    $(window).on('message', this.onMessage)
  },

  destroyed () {
    $(window).off('message', this.onMessage)
  },

  methods: {
    onMessage (e) {
      const data = e.originalEvent.data

      if (!data.selecteds) {
        return
      }

      this.selectedFiles = data.selecteds
      console.log(this.selectedFiles)
    },

    openFileManager () {
      let width = parseInt((window.screen.width * 80) / 100, 10)
      let height = parseInt((window.screen.height * 70) / 100, 10)

      if (width < 640) {
        width = 640
      }

      if (height < 420) {
        height = 420
      }

      const top = parseInt((window.screen.height - height) / 2, 10)
      const left = parseInt((window.screen.width - width) / 2, 10)

      const options = `location=no,menubar=no,toolbar=no,dependent=yes,minimizable=no,modal=yes,alwaysRaised=yes,resizable=yes,scrollbars=yes,width=${width},height=${height},top=${top},left=${left}`
      window.open('/file/manager', null, options)
    }
  }
}
</script>

<style lang="css">
</style>
