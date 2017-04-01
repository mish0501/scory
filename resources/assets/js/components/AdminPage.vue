<template lang="html">
  <div class='row' id='content-wrapper'>
      <loading v-if="isLoading"></loading>
      <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'AdminWrapper',

  beforeCreate () {
    this.$http.get('/api/user').then((response) => {
      this.$store.dispatch('set_user', response.data)
    }, (error) => {
      console.error(error);
    })
  },

  data () {
    return {
      isLoading: false,
      table: {}
    }
  },

  watch: {
    isLoading(loading){
      if(!loading){
        this.setToggles()
      }
    }
  },

  methods: {
    setDataTable() {
      this.$nextTick(() => {
        var table = $(".table").dataTable({
          sPaginationType: "bootstrap",
          fnDrawCallback () {
            return $(".dataTables_wrapper").addClass("scrollable-area");
          }
        })

        this.table = table
      })
    },

    redrawTable() {
      this.table.fnDestroy()
      this.setDataTable()
    },

    setToggles(){
      $(".box .box-collapse").on("click", function(e) {
        var box;
        box = $(this).parents(".box").first();
        box.toggleClass("box-collapsed");
        e.preventDefault();
        return false;
      });
    }
  }
}
</script>
