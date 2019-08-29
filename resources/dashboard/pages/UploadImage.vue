<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col sm="12">
        <bootstrap-alert></bootstrap-alert>

        <b-card header="Upload Image and copy URL">
          <div class="form-group">
            <label class="d-block" for>Upload Image</label>
            <input
              type="file"
              ref="image"
              name="image"
              class="imginput"
              id="image"
              @change.prevent="uploadImage"
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
              </span>
            </label>
          </div>

          <div class="form-group">
            <label for>Image URL</label>
            <div class="px-3 py-3 bg-secondary position-relative">
              <p class>{{image_url}}</p>
              <button @click="copyUrl" v-if="image_url" class="copy-btn btn btn-purple rounded-0"><i class="fas fa-copy"></i> Copy</button>
            </div>
          </div>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      uploading: false,
      selected_image: null,
      image_url: null
    };
  },

  methods: {
    ...mapActions("Alert", ["setAlert"]),
    copyUrl() {
      this.$clipboard(this.image_url)
      this.$awn.success("Image URL Copied to clipboard!");
    },
    uploadImage() {
      this.uploading = true;
      const image = this.$refs.image.files[0];
      this.selected_image = image;

      const file = new FormData();
      file.append("image", image);
      axios
        .post("upload-image", file)
        .then(response => {
          this.image_url = response.data.data;
          this.$eventHub.$emit("create-success");
        })
        .catch(error => {
          let message = error.response.data.message || error.message;
          let errors = error.response.data.errors;
          this.setAlert({ message: message, errors: errors, color: "danger" });
        })
        .finally(() => {
          this.selected_image = null;
          this.uploading = false;
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