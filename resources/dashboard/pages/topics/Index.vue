<template>
  <b-card key="table">
    <!-- TODO: Implement filtewr by course -->
    <div slot="header" class="d-flex">
      <h5>All Topics</h5>
      <div class="ml-auto">
        <router-link to="/topics/create" class="btn btn-sm btn-primary">Add New</router-link>
      </div>
    </div>
    <div class="table-responsive-sm">
      <table class="table table-striped">
        <thead>
          <tr>
            <th style="max-width: 200px;" scope="col">Title</th>
            <th>Course</th>
            <th>Index</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr :key="topic.id" v-for="topic in topics">
            <td>{{topic.title}}</td>
            <td>
              <router-link :to="`courses/${topic.course_id}/edit`" class="">{{topic.course}}</router-link>
            </td>
            <!-- <td>{{project.start_date}} to {{project.end_date}}</td> -->
            <td>
              {{topic.index}}
            </td>
            <td>
              <router-link
                :to="`/topics/${topic.id}/edit`"
                class="btn btn-sm btn-primary"
              >Edit Details</router-link>

              <router-link
                :to="`/topics/${topic.id}/slides`"
                class="btn btn-sm btn-info"
              >Slides</router-link>

              <router-link
                :to="`/topics/${topic.id}/questions`"
                class="btn btn-sm btn-purple"
              >Questions</router-link>

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
    ...mapGetters("TopicIndex", ["topics", "meta", "loading", "courses"])
  },
  methods: {
    ...mapActions("TopicIndex", ["fetchData", "resetState"])
  }
};
</script>