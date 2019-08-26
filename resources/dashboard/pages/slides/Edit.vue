<template>
  <div class="animated fadeIn">
    <slide-form></slide-form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import SlideForm from "./SlideForm";
export default {
  components: {
    SlideForm
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
      ...mapGetters("SlideSingle", ["item"])
  },
  methods: {
    ...mapActions("SlideSingle", ["fetchData", "resetState", "fetchTopic"])
  }
};
</script>