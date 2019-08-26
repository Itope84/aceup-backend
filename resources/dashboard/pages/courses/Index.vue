<template>
  <b-card key="table">
    <div slot="header" class="d-flex">
      <h5>All Projects</h5>
      <div class="ml-auto">
        <router-link to="/courses/create" class="btn btn-sm btn-primary">Add New</router-link>
      </div>
    </div>
    <div class="table-responsive-sm">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="max-width: 200px;" scope="col">Title</th>
            <!-- <th scope="col">Description</th> -->
            <!-- <th>Period</th> -->
            <th>Color</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr :key="course.id" v-for="course in courses">
            <td>{{course.title}}</td>
            <td>
              {{course.color_scheme}}
            </td>
            <!-- <td>{{project.start_date}} to {{project.end_date}}</td> -->
            <td>
              <a target="_blank" :href="course.featured_image" class="">{{course.featured_image}}</a>
            </td>
            <td>
              <router-link
                :to="`/courses/${course.id}/edit`"
                class="btn btn-sm btn-primary"
              >Edit Details</router-link>
              <a
                href="#editProject"
                class="btn btn-sm btn-danger disabled"
              >Delete</a>
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
import {mapGetters, mapActions} from "vuex"
export default {
    components: {
        VbPaginator
    },
  created() {
    this.fetchData();
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("CourseIndex", ["courses", "meta", "loading"])
  },
  methods: {
    ...mapActions("CourseIndex", ["fetchData", "resetState"])
  }
};
</script>