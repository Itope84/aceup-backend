<template>
  <div class="animated fadeIn">
    <question-form :topic-id="parseInt($route.params.topicId)"></question-form>
  </div>
</template>

<script>
import QuestionForm from "./QuestionForm"
export default {
    components: {
      QuestionForm
    }
};
</script>