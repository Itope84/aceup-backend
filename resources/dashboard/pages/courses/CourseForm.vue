<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col sm="12">
        <bootstrap-alert />

        <b-card>
          <div slot="header">Create / Edit Course</div>

          <div class="form-group">
            <label for>Course Title</label>
            <input type="text" class="form-control" :value="item.title" @input="updateTitle" />
          </div>

          <div class="form-group">
            <label class="d-block" for>Featured Image</label>
            <input
              type="file"
              ref="image"
              name="image"
              class="imginput"
              id="image"
              @change.prevent="updateFeatured_image"
              accept="image/*"
            />
            <label for="image">
              <span class>
                <span class="btn btn-primary px-4" :class="{'disabled': uploading}">
                  <transition name="fade" mode="out-in">
                    <span v-if="uploading">
                      <i :class="{'spinner fas fa-circle-notch fa-spin': uploading}"></i>
                    </span>
                  </transition>Browse
                </span>
                <span
                  class="d-block"
                  v-if="selected_image && selected_image"
                  v-html="selected_image.name + `(${parseFloat(selected_image.size/1000000).toFixed(2)} MB)`"
                ></span>
                <span class="form-text d-block">Maximum: 5MB.</span>
              </span>
            </label>
          </div>

          <vue-ckeditor name="body" :id="'body'" :value="item.description" />
        </b-card>
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
    ...mapGetters("CourseSingle", ["item", "loading", "uploading"])
  },

  destroyed() {
    this.resetState();
    this.selected_image = null;
  },

  methods: {
    ...mapActions("CourseSingle", [
      "storeData",
      "resetState",
      "setTitle",
      "setDescription",
      "setFeatured_image",
      "setColor_scheme"
    ]),
    updateDescription(value) {
      this.setDescription(value);
    },
    updateTitle(e) {
      this.setTitle(e.target.value);
    },
    updateFeatured_image(e) {
      const file = this.$refs.image.files[0];
      this.selected_image = file;

      this.setFeatured_image(file);
    },
    updateAdditional_resources(e) {
      this.setAdditional_resources(e.target.value);
    },
    updateColor_scheme(e) {
      this.setColor_scheme(e.target.value);
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: "modules.index" });
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