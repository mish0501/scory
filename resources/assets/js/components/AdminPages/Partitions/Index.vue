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

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
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
              <th v-if="isAdmin">
                Опции
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="partition in partitions">
              <td>{{ partition.name }}</td>
              <td>{{ partition.subject.name }}</td>
              <td class="class-col">{{ partition.class }}. Клас</td>
              <td v-if="isAdmin">
                <div class='text-right'>
                    <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'EditPartition', params:{ id: partition.id }}">
                      <i class="icon-edit"></i>
                      <span>Редактирай</span>
                    </router-link>
                    <button class="btn btn-danger btn-xs">
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
</template>

<script>
export default {
  data () {
    return {
      partitions: {}
    }
  },

  beforeCreate () {
    this.$http.get('/api/partition').then(
      (response) => {
        this.partitions = response.data
      }, (error) => {
        console.log(error);
      }
    )

    this.$store.dispatch('reset_test')
  },

  computed:{
    isAdmin(){
      return this.$store.getters.User.role == 'admin'
    }
  },

  methods: {}
}
</script>

<style lang="css">
</style>
