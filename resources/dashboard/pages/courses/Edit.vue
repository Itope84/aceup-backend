<template>
  <div class="animated fadeIn">
    <course-form></course-form>
  </div>
</template>

<script>
import CourseForm from "./CourseForm";
import { mapActions } from "vuex";
export default {
  components: {
    CourseForm
  },
  watch: {
    "$route.params.id": function(id) {
      this.resetState();
      this.fetchData(id);
    }
  },
  created() {
    this.fetchData(this.$route.params.id);
  },
  methods: {
    ...mapActions("CourseSingle", ["fetchData", "resetState"])
  }
};
</script>