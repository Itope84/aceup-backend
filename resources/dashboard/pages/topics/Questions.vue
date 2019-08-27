<template>
  <b-card key="table">
    <!-- TODO: Implement filtewr by course -->
    <div slot="header" class="d-flex">
      <div>
        <h5>{{meta.total}} Questions</h5>
        <h6 class="small mb-0">{{topic.title}}</h6>
      </div>
      <div class="ml-auto">
        <router-link
          :to="`/topics/${$route.params.topicId}/questions/create`"
          class="btn btn-sm btn-primary"
        >New Question</router-link>
      </div>
    </div>

    <b-card no-body class="mb-2" v-for="question in questions" :key="question.id">
      <div slot="header" class="d-flex">
        <h6 class="mb-0">Question</h6>
        <div class="ml-auto">
          <router-link :to="`/questions/${question.id}/edit`" class="btn btn-sm btn-primary">Edit</router-link>
        </div>
      </div>
      <div v-html="question.body" class="px-4 py-2"></div>

      <div class="row py-2 border-top px-2 mx-0">
        <div class="col-md-6 mb-3" v-for="(option, index) in question.options" :key="index">
          <h6>
            Option {{option.key}}
            <span
              v-if="option.is_answer"
              class="badge badge-pill badge-success"
            >Answer</span>
          </h6>
          <div v-html="option.body"></div>
        </div>
      </div>
      <div class="px-4 border-top pt-2">
        <h6>Explanation</h6>
        <div v-html="question.explanation"></div>
      </div>
    </b-card>

    <vb-paginator
      :page-count="meta.last_page || 1"
      v-model="meta.current_page"
      :click-handler="getQuestions"
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
      this.fetchQuestions({ topic: id });
    }
  },
  created() {
    this.fetchTopic(this.$route.params.topicId);
    this.fetchQuestions({ topic: this.$route.params.topicId });
  },
  destroyed() {
    this.resetState();
  },
  computed: {
    ...mapGetters("QuestionIndex", ["questions", "meta", "loading", "topic"])
  },
  methods: {
    ...mapActions("QuestionIndex", [
      "fetchQuestions",
      "resetState",
      "fetchTopic"
    ]),
    getQuestions(page) {
      this.fetchQuestions({ topic: this.$route.params.topicId, page: page });
    }
  }
};
</script>