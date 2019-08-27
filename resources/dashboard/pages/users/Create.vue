<template>
  <form action="#" method="POST" @submit.prevent="submit">
    <bootstrap-alert />
    <b-card key="table">
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
      loading: false,
      meta: {}
    };
  },
  computed: {},
  methods: {
    ...mapActions("Alert", ["setAlert"]),
    submit() {
      this.loading = true;

      let params = new FormData();

      for (let fieldName in this.user) {
        let fieldValue = this.user[fieldName];
        if (typeof fieldValue !== "object" && !!fieldValue) {
          params.set(fieldName, fieldValue);
        }
      }

      axios
        .post("/users", params)
        .then(response => {
          this.$router.go(-1);
          this.$eventHub.$emit("create-success");
        })
        .catch(error => {
          let message = error.response.data.message || error.message;
          let errors = error.response.data.errors;
          this.setAlert({ message: message, errors: errors, color: "danger" });
        })
        .finally(() => {
          this.loading = false;
        });
    }
  }
};
</script>

<style scoped>
.card-body >>> table > tbody > tr > td {
  cursor: pointer;
}
</style>
