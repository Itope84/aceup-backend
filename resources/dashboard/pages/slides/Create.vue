<template>
  <div class="animated fadeIn">
    <slide-form :topic-id="parseInt($route.params.topicId)"></slide-form>
  </div>
</template>

<script>
import SlideForm from "./SlideForm"
export default {
    components: {
      SlideForm
    }
};
</script>