<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="icon-book"></i>
        Всички раздели
      </h1>

      <div class='pull-right' v-if="isAdmin">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'partition/create' }">
            <i class='icon-plus'></i>
            Добави предмет
          </router-link>
        </div>
      </div>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <div class="responsive-table">
          <div class="scrollable-area">
            <table class='data-table table table-bordered table-hover table-striped' style='margin-bottom:0;'>
              <thead>
                <tr>
                  <th>
                    Име на предмета
                  </th>
                  <th>
                    Име на предмета
                  </th>
                  <th>
                    Клас
                  </th>
                  <th v-if="isAdmin || isTeacher">
                    Опции
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="partition in partitions">
                  <td>{{ partition.name }}</td>
                  <td>{{ partition.subject.name }}</td>
                  <td class="class-col">{{ partition.class }}. Клас</td>
                  <td v-if="isAdmin || isTeacher">
                    <div class='text-right'>
                        <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'EditPartition', params:{ id: partition.id }}">
                          <i class="icon-edit"></i>
                          <span>Редактирай</span>
                        </router-link>
                        <button class="btn btn-danger btn-xs" @click="DeletePartition(partition.id)" v-if="!isTeacher">
                          <i class="icon-remove"></i>
                          <span>Изтрий</span>
                        </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Alert from "../../Alert.vue"
export default {
  data () {
    return {
      partitions: [],
      partitionsIds: [],
      hasAlert: false,
      alert: {}
    }
  },

  beforeCreate () {
    this.$parent.isLoading = true
    this.$http.get('/api/partition').then(
      (response) => {
        this.partitions = response.data
        this.subjectsIds = response.data.map(el => el.id)
        this.$parent.isLoading = false
      }, (error) => {
        console.log(error);
      }
    )

    this.$store.dispatch('reset_test')
  },

  components: {
    "alert": Alert
  },

  computed:{
    isAdmin(){
      return this.$store.getters.User.role == 'admin'
    },

    isTeacher(){
      return this.$store.getters.User.role == 'teacher'
    }
  },

  methods: {
    DeletePartition(id) {
      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.delete('/api/partition/' + id).then((response) => {
        this.hasAlert = true

        console.log(response.data);

        this.alert = {
          type: 'alert-success',
          messages: response.data.success
        }

        const index = this.partitionsIds.indexOf(id)
        this.partitions.splice(index, 1)
        this.partitionsIds.splice(index, 1)
        this.$parent.isLoading = false
      }, (error) => {
        console.error(error);
      })
    }
  }
}
</script>

<style lang="css">
</style>
