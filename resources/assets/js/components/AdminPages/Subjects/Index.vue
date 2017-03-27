<template lang="html">
  <div class='col-xs-12'>
    <div class='page-header page-header-with-buttons'>
      <h1 class='pull-left'>
        <i class="fa fa-book"></i>
        Всички предмети
      </h1>

      <div class='pull-right' v-if="can('create-subject')">
        <div class='btn-group'>
          <router-link class="btn btn-success" :to="{ path: 'subject/create' }">
            <i class='fa fa-plus'></i>
            Добави предмет
          </router-link>
        </div>
      </div>
    </div>

    <alert :alert="alert" v-if="hasAlert"></alert>

    <div class='box bordered-box' style='margin-bottom:0;'>
      <div class='box-content'>
        <div class="responsive-table">
          <table class='table table-bordered table-hover table-striped' style='margin-bottom:0;' v-data-table>
            <thead>
              <tr>
                <th>
                  Име на предмета
                </th>
                <th>
                  Клас
                </th>
                
                <th v-if="can('edit-subject') || can('delete-subject')">
                  Опции
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="subject in subjects">
                <td>{{ subject.name }}</td>
                <td class="class-col">{{ subject.class }}. Клас</td>
                <td v-if="can('edit-subject') || can('delete-subject')">
                  <div class='text-right'>
                      <router-link tag="a" class="btn btn-success btn-xs" :to="{ name:'EditSubject', params:{ id: subject.id }}" v-if="can('edit-subject')">
                        <i class="fa fa-edit"></i>
                        <span>Редактирай</span>
                      </router-link>
                      <button class="btn btn-danger btn-xs" @click="DeleteSubject(subject.id)" v-if="can('delete-subject')">
                        <i class="fa fa-remove"></i>
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
</template>

<script>
import Alert from "../../Alert.vue"
export default {
  name: 'SubjectsIndex',
  data () {
    return {
      subjects: [],
      subjectsIds: [],
      hasAlert: false,
      alert: {}
    }
  },

  components: {
    "alert": Alert
  },

  created () {
    this.$parent.isLoading = true
    this.$http.get('/api/subject').then(
      (response) => {
        this.subjects = response.data
        this.subjectsIds = response.data.map(el => el.id)

        this.$parent.setDataTable()
        this.$parent.isLoading = false
      }, (error) => {
        console.log(error);
      }
    )
  },

  methods: {
    DeleteSubject(id) {
      this.hasAlert = false
      this.$parent.isLoading = true

      this.$http.delete('/api/subject/' + id).then((response) => {
        this.hasAlert = true

        this.alert = {
          type: 'alert-success',
          messages: response.data.success
        }

        const index = this.subjectsIds.indexOf(id)

        this.$parent.table.fnDestroy()

        this.subjects.splice(index, 1)
        this.subjectsIds.splice(index, 1)

        this.$parent.setDataTable()

        this.$parent.isLoading = false
      }, (error) => {
        console.error(error);
      })
    }
  }
}
</script>
