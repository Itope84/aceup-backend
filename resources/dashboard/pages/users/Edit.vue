<template>
  <form action="#" method="POST" @submit.prevent="submit">
    <b-card key="table">
      >
      <div slot="header" class="d-flex">
        <h5 class="text-capitalize">Create New Editor</h5>
      </div>
      <div class="form-group">
        <label>First Name</label>
        <input v-model="user.first_name" type="text" class="form-control" />
      </div>

      <div class="form-group">
        <label>Last Name</label>
        <input type="text" class="form-control" v-model="user.last_name" />
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" v-model="user.email" />
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" v-model="user.password" />
      </div>

      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" class="form-control" v-model="user.password_confirmation" />
      </div>

      <div slot="footer">
        <vue-button-spinner
          class="btn btn-primary btn-sm"
          :is-loading="loading"
          :disabled="loading"
        >Save</vue-button-spinner>
      </div>
    </b-card>
  </form>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "Users",
  data: () => {
    return {
      user: {
        first_name: "",
        last_name: "",
        email: "",
        password: ""
      },
      meta: {}
    };
  },
  components: {
    VbPaginator
  },
  computed: {},
  watch: {
    "$route.params.type": function(type) {
      this.fetchData(1);
    }
  },
  methods: {
    ...mapActions("Alert", ["setAlert"]),
    fetchData(page = 1) {
      axios.get(`/users?role=${this.$route.params.type}`).then(response => {
        this.users = response.data.data;
        this.meta = response.data.meta;
      });
    },

    submit() {
      this.loading = true;

      let params = new FormData();
      params.set("_method", "PUT");
      for (let fieldName in this.user) {
        let fieldValue = this.user[fieldName];
        if (typeof fieldValue !== "object" && !!fieldValue) {
          params.set(fieldName, fieldValue);
        }
      }

      axios
        .post(`/users/${this.params.id}`, params)
        .then(response => {
          this.$router.go(-1);
          this.$eventHub.$emit("create-success");
        })
        .catch(error => {
          this.setAlert({ message: message, errors: errors, color: "danger" });
        });
    }
  },
  created() {
    this.fetchData();
  }
};
</script>

<style scoped>
.card-body >>> table > tbody > tr > td {
  cursor: pointer;
}
</style>
