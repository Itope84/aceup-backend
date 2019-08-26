<template>
  <div class="animated fadeIn">
    <topic-form></topic-form>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import TopicForm from "./TopicForm";
export default {
  components: {
    TopicForm
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
    ...mapActions("TopicSingle", ["fetchData", "resetState"])
  }
};
</script>