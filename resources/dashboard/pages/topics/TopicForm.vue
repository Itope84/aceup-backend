<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col sm="12">
        <bootstrap-alert />

        <form action="#" method="POST" @submit.prevent="submitForm">
          <b-card show-footer>
            <div slot="header">Create / Edit Topic</div>
            <div class="form-group">
              <label for>Topic</label>
              <input
                type="text"
                class="form-control"
                :value="item.title"
                @input="updateInput($event, 'title')"
              />
            </div>

            <div class="form-group">
              <label>Select Course</label>
              <v-select
                :value="topic_course"
                label="title"
                @input="updateCourse_id"
                :options="courses"
                :reduce="course => course.id"
              />

              <!-- <select class="form-control" @input="updateInput($event, 'course_id')" :value="item.course_id">
                <option value>Select Course</option>
                <option v-for="course in courses" :key="course.id" :value="course.id">{{course.title}}</option>
              </select>-->
            </div>

            <div class="form-group">
              <label>Topic Index (E.g. Topic 1, topic 2)</label>
              <input
                type="number"
                class="form-control"
                :value="item.index"
                @input="updateInput($event, 'index')"
              />
            </div>

            <div class="form-group">
              <label>Topic Introduction</label>
              <vue-ckeditor
                name="intro"
                :id="'intro'"
                :value="item.introduction"
                @input="updateDescription"
              />
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
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      selected_image: null
    };
  },
  computed: {
    ...mapGetters("TopicSingle", ["item", "loading", "courses"]),
    topic_course() {
      return this.courses.filter(
        course => this.item.course_id === course.id
      )[0];
    }
  },

  created() {
    this.fetchCourses();
  },

  destroyed() {
    this.resetState();
    this.selected_image = null;
  },

  methods: {
    ...mapActions("TopicSingle", [
      "storeData",
      "updateData",
      "resetState",
      "setValue",
      "fetchCourses"
    ]),
    updateCourse_id(val) {
      this.setValue({key: "course_id", val: val});
    },
    updateDescription(value) {
      this.setValue({key: "introduction", val: value});
    },

    // for use only with native input elements
    updateInput(event, key) {
      this.setValue({key, val: event.target.value});
    },
    submitForm() {
      this.item.id
        ? this.updateData()
            .then(() => {
              this.$router.push({ name: "All Topics" });
              this.$eventHub.$emit("update-success");
            })
            .catch(error => {
              console.error(error);
            })
        : this.storeData()
            .then(() => {
              this.$router.push({ name: "All Topics" });
              this.$eventHub.$emit("create-success");
            })
            .catch(error => {
              console.error(error);
            });
    }
  }
};
</script>

<style lang="scss" scoped>
input.imginput {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
</style>