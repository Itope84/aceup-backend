<template>
  <div class="animated fadeIn">
    <question-form></question-form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import QuestionForm from "./QuestionForm";
export default {
  components: {
    QuestionForm
  },

  watch: {
    "$route.params.id": function(id) {
      this.resetState();
      this.fetchData(id);
    }
  },
  created () {
      this.fetchData(this.$route.params.id);
  },
  computed: {
      ...mapGetters("QuestionSingle", ["item"])
  },
  methods: {
    ...mapActions("QuestionSingle", ["fetchData", "resetState", "fetchTopic"])
  }
};
</script>