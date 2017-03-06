<template lang="html">
  <div class="col-md-12">
    <div class="row" v-if="images.length > 0">
      <div class="col-md-2 image" v-for="image in images">
        <img :src="image.url" alt="" class="center-block img-responsive" >
      </div>
    </div>

    <br><br>

    <div class="row" v-if="downloads.length > 0">
      <div class="col-md-3" v-for="download in downloads">
        <div class="tabs word-wrap">
          <span @click="openFile(download.url)"> {{ download.data.name }} </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'files'
  ],

  data() {
    return {
      images: [],
      downloads: []
    }
  },

  mounted() {
    let files = this.files
    for (var i = 0; i < files.length; i++){
      if(files[i].type == "image"){
        this.images.push(files[i])
      }else if (files[i].type == "download") {
        this.downloads.push(files[i])
      }
    }
  },

  methods: {
    openFile(url) {
      window.open(url, "_blank")
    }
  }
}
</script>

<style lang="css">
.word-wrap {
  word-wrap: break-word;
}

.image {
  margin-bottom: 10px;
}
</style>
