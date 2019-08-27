<template>
  <b-card key="table">
    <!-- TODO: Implement filtewr by course -->
    <div slot="header" class="d-flex">
      <div>
        <h5>{{meta.total}} Slides</h5>
        <h6 class="small mb-0">{{topic.title}}</h6>
      </div>
      <div class="ml-auto">
        <router-link
          :to="`/topics/${$route.params.topicId}/slides/create`"
          class="btn btn-sm btn-primary"
        >New Slide</router-link>
      </div>
    </div>

    <!-- Single slide -->
    <b-card v-for="slide in slides" :key="slide.id">
      <div slot="header" class="d-flex">
        <h6 class="mb-0">
          Slide {{slide.index}}
          <span
            class="badge badge-pill badge-primary"
            v-if="slide.is_question"
          >Question</span>
        </h6>

        <div class="ml-auto">
          <router-link :to="`/slides/${slide.id}/edit`" class="btn btn-sm btn-primary">Edit</router-link>
        </div>
      </div>

      <div v-html="slide.body"></div>

      <template v-if="slide.is_question">
        <hr />
        <div v-for="(option, index) in slide.options" :key="index">
          <h6>
            Option {{option.key}}
            <span
              v-if="option.is_answer"
              class="badge badge-pill badge-success"
            >Answer</span>
          </h6>
          <div v-html="option.body"></div>
        </div>
      </template>
    </b-card>

    <vb-paginator
      :page-count="meta.last_page || 1"
      v-model="meta.current_page"
      :click-handler="getSlides"
    ></vb-paginator>
  </b-card>
</template>

<script>
import VbPaginator from "../../views/components/VuePaginator";
import { mapGetters, mapActions } from "vuex";
export default {
  components: {
    VbPaginator
  },
  watch: {
    "$route.params.topicId": function(id) {
      this.resetState();
      this.fetchSlides({ topic: id });
    }
  },
  created() {
    this.fetchTopic(this.$route.params.topicId);
    this.fetchSlides({ topic: this.$route.params.topicId });
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("SlideIndex", ["slides", "meta", "loading", "topic"])
  },
  methods: {
    ...mapActions("SlideIndex", ["fetchSlides", "resetState", "fetchTopic"]),
    getSlides(page) {
      this.fetchSlides({ topic: this.$route.params.topicId, page: page });
    }
  }
};
</script>