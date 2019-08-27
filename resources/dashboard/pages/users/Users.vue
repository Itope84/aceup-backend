<template>
  <b-card key="table">
    <!-- TODO: Implement filtewr by course -->
    <div slot="header" class="d-flex">
      <h5 class="text-capitalize">{{$route.params.type}}s</h5>
      <div class="ml-auto">
        <router-link to="/users/create" class="btn btn-sm btn-primary">Add New</router-link>
      </div>
    </div>
    <div class="table-responsive-sm">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="max-width: 200px;" scope="col">First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr :key="user.id" v-for="user in users">
            <td>{{user.first_name}}</td>
            <td>{{user.last_name}}</td>
            <td>{{user.email}}
            </td>
            <td>
              <router-link
                :to="`/users/${user.id}/edit`"
                class="btn btn-sm btn-primary"
              >Edit</router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <vb-paginator
      :page-count="meta.last_page || 1"
      v-model="meta.current_page"
      :click-handler="fetchData"
    ></vb-paginator>
  </b-card>
</template>

<script>
import VbPaginator from "../../views/components/VuePaginator"
export default {
  name: 'Users',
  data: () => {
    return {
      users: [],
      meta: {}
    }
  },
  components: {
      VbPaginator
  },
  computed: {
  },
  watch: {
      "$route.params.type": function (type) {
          this.fetchData(1)
      }
  },
  methods: {
    fetchData (page = 1) {
      axios.get(`/users?role=${this.$route.params.type}`).then(response => {
          this.users = response.data.data
          this.meta = response.data.meta
      })
    },

  },
  created () {
    this.fetchData()
  }
}
</script>

<style scoped>
.card-body >>> table > tbody > tr > td {
  cursor: pointer;
}
</style>
