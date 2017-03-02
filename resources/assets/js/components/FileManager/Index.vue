<template lang="html">
  <div>
    <dropzone
    id="file-manager"
    url="/file/upload"
    @vdropzone-removedFile="removeFile"
    @vdropzone-success="success"
    :useFontAwesome="true"
    :useCustomDropzoneOptions="true"
    :dropzoneOptions="dropzoneOptions"
    ></dropzone>
    <div class="footer" v-if="hasOpener()">
      <button type="button" class="btn btn-primary" @click="selectFiles">Избери</button>
    </div>
  </div>
</template>

<script>
import Dropzone from 'vue2-dropzone'

export default {
  name: 'FileManager',
  data () {
    return {
      dropzoneOptions: {
        dictDefaultMessage: `
          <i class="fa fa-cloud-upload"></i>
          <br>
          Пуснете файловете тук, за да се качат.
        `,
        headers: { 'X-CSRF-TOKEN': Laravel.csrfToken },
        maxFilesize: 100,
        thumbnailWidth: 150,
        thumbnailHeight: 150,
        addRemoveLinks: true,
        dictRemoveFile: 'Изтрий',
        previewTemplate: `
          <div class="dz-preview dz-file-preview">
            <div class="dz-image">
              <img data-dz-thumbnail />
            </div>
            <div class="dz-details">
              <div class="dz-size">
                <span data-dz-size></span>
              </div>
              <div class="dz-filename">
                <span data-dz-name></span>
              </div>
            </div>
            <div class="dz-progress">
              <span class="dz-upload" data-dz-uploadprogress></span>
            </div>
            <div class="dz-error-message">
              <span data-dz-errormessage></span>
            </div>
            <div class="dz-success-mark"><i class="fa fa-check"></i></div>
            <div class="dz-error-mark"><i class="fa fa-close"></i></div>
            <div class="dz-select-btn"><i class="fa fa-check"></i></div>
          </div>`
      },
      selecteds: null
    }
  },

  created () {
    if (window.fileCount == 'one') {
      this.selecteds = ""
    }else if (window.fileCount == 'many') {
      this.selecteds = []
    }

    this.$http.get('/file/all').then(
      (response) => {
        const dropzone = this.$children[0].dropzone

        for (let i in response.data) {
          let mockFile = response.data[i].data
          mockFile.id = response.data[i].id

          dropzone.emit('addedfile', mockFile)
          dropzone.emit('complete', mockFile)
          dropzone.emit('success', mockFile, response.data[i])
          dropzone.files.push(mockFile)
          dropzone.createThumbnailFromUrl(mockFile, response.data[i].url);
        }
      }, console.error
    )
  },

  components: {
    Dropzone
  },

  methods: {
    removeFile (file) {
      this.$http.delete('/file/'+file.id).then(null, console.error)
    },

    hasOpener () {
      return window.opener
    },

    success (file, response) {
      file.id = response.id

      const fileEl = $(file.previewElement)

      fileEl.attr('data-id', file.id)

      const selectBtn = fileEl.find('.dz-select-btn')
      const vm = this

      if(window.files){
        var files = window.files

        for(var i = 0; i < files.length; i++){
          let id = files[i].id

          if(file.id == id){
            $("div").find("[data-id='" + id + "']").addClass('dz-selected')
            this.selecteds.push(id)
          }
        }
      }

      selectBtn.on('click', function () {
        const preview = $(this).parent('[data-id]')
        const id = preview.attr('data-id')

        preview.toggleClass('dz-selected')

        if(window.fileCount == 'one') {

          if (vm.selecteds == id) {
            vm.selecteds = ""
          } else {
            if(vm.selecteds != null){
              let current = vm.selecteds
              $("div").find("[data-id='" + current + "']").removeClass('dz-selected')
            }

            vm.selecteds = id
          }

        }else if (window.fileCount == 'many') {

          const index = vm.selecteds.indexOf(id)

          if (index > -1) {
            vm.selecteds.splice(index, 1)
          } else {
            vm.selecteds.push(id)
          }

        }
      })
    },

    selectFiles () {
      const selecteds = this.selecteds
      let files = []

      for(var i = 0; i < selecteds.length; i++){
        let name = $("div").find("[data-id='" + selecteds[i] + "']").find("[data-dz-name]").html()
        files.push({
          id: selecteds[i],
          name: name
        })
      }

      window.opener.postMessage({ files }, '*')

      window.close()
    }
  }
}
</script>

<style lang="css">
  .dropzone .dz-select-btn {
    z-index: 100;
    position: absolute;
    width: 30px;
    height: 30px;
    top: -5px;
    left: -5px;
    line-height: 30px;
    text-align: center;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0px 3px 8px 0px rgba(0,0,0,0.34);
  }

  .dropzone.dz-clickable .dz-select-btn,
  .dropzone.dz-clickable .dz-select-btn i {
    cursor: pointer;
  }

  .dropzone .dz-select-btn i {
    color: #848484;
  }

  .dz-preview.dz-selected .dz-select-btn {
    background: #82d85f;
  }

  .dz-preview.dz-selected .dz-select-btn i {
    color: #fff;
  }

  .dropzone .dz-preview .dz-image {
    width: 150px !important;
    height: 150px !important;
  }

  .dropzone .dz-preview {
    width: 150px;
    height: 150px;
  }

  .dropzone {
    min-height: 100vh !important;
    margin-bottom: 56px;
  }

  .footer {
    position: fixed;
    z-index: 1000;
    height: 56px;
    background: #f3f3f3;
    left: 0;
    right: 0;
    bottom: 0;
    line-height: 56px;
    padding: 0 10px;
    border-top: 1px solid #d6d6d6;
  }
</style>
