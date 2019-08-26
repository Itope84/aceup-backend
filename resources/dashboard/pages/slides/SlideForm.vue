<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col sm="12">
        <bootstrap-alert />

        <b-modal
          title="Please Confirm"
          v-model="showDeleteConfirmation"
          @ok="deleteOption"
          ok-variant="danger"
        >
          Are you sure you want to delete this option?
          <span slot="modal-ok">Confirm</span>
        </b-modal>

        <form action="#" method="POST" @submit.prevent="submitForm">
          <b-card show-footer>
            <div slot="header" class=" d-flex">
              <h5>Create / Edit Slide</h5>

              <button @click.prevent="$router.go(-1)" class="btn btn-sm btn-primary ml-auto">Go Back</button>
            </div>

            <div class="form-group">
              <label>Topic:</label>
              <!-- We only create slides from a topic, so no need to select here, just show Topic -->
              <h5>{{topic ? topic.title : ""}}</h5>
            </div>

            <div class="form-group px-0 col-md-5">
              <label>Slide Index (E.g. Slide 1, slide 2)</label>
              <div class="input-group">
                <span
                  class="btn btn-secondary input-group-prefix"
                  style="border-top-right-radius: 0; border-bottom-right-radius: 0;"
                >Slide #</span>
                <input
                  type="number"
                  class="form-control"
                  :value="item.index"
                  @input="updateInput($event, 'index')"
                />
              </div>
            </div>

            <div class="form-group d-flex align-items-center my-3">
              <c-switch
                class="mx-1"
                color="primary"
                name="is_question"
                :value="1"
                variant="pill"
                label
                v-bind="labelTxt"
                :checked="!!item.is_question"
                @change="updateIsQuestion"
                v-model="item.is_question"
                :uncheckedValue="0"
              />Is this slide in form of a question?
            </div>

            <div class="form-group">
              <label>Slide Body</label>
              <vue-ckeditor name="intro" :id="'intro'" :value="item.body" @input="updateBody" />
            </div>

            <div v-if="item.is_question">
              <h5>Options</h5>
              <hr />

              <div
                class="form-group border-bottom"
                v-for="(option, index) in item.options"
                :key="option.key || index"
              >
                <hr />
                <div class="d-flex align-items-center">
                  <label>Option {{option.key}}:</label>
                  <button
                    type="button"
                    class="btn btn-sm btn-danger ml-auto"
                    @click="initRemoval(index)"
                  >Remove</button>
                </div>

                <div class="d-flex align-items-center my-2">
                  <c-switch
                    class="mx-1"
                    color="primary"
                    name="is_question"
                    :value="1"
                    label
                    v-bind="labelTxt"
                    variant="pill"
                    :checked="!!option.is_answer"
                    @change="val => updateOption(index, 
                  'is_answer', val)"
                    v-model="option.is_answer"
                    :uncheckedValue="0"
                  />Is this option the correct answer?
                </div>

                <vue-ckeditor
                  :name="`option${index}`"
                  :id="`option${index}`"
                  :value="option.body"
                  @input="val => updateOption(index, 
                  'body', val)"
                />
              </div>

              <button
                type="button"
                class="btn btn-sm btn-primary"
                @click.prevent="newOption"
              >New Option</button>
            </div>

            <div slot="footer">
              <vue-button-spinner
                class="btn btn-primary btn-sm"
                :is-loading="loading"
                :disabled="loading"
              >Save</vue-button-spinner>
            </div>
          </b-card>
        </form>
      </b-col>
    </b-row>
  </div>
</template>

<script>
// just for fun
import { cloneDeep } from "lodash";
import { Switch as cSwitch } from "@coreui/vue";
import { mapGetters, mapActions } from "vuex";
export default {
  props: {
    topicId: {
      required: false,
      type: Number
    }
  },
  components: {
    cSwitch
  },
  data() {
    return {
      optionToDelete: null,
      showDeleteConfirmation: false,
      selected_image: null,
      labelTxt: {
        dataOn: "Yes",
        dataOff: "No"
      }
    };
  },
  computed: {
    ...mapGetters("SlideSingle", ["item", "loading", "topic"])
    // slide_topic() {
    //   return this.topics.filter(topic => this.item.topic_id === topic.id)[0];
    // },
    // options
  },

  created() {
    if (this.topicId) {
      this.fetchTopic(this.topicId);
      this.setValue({ key: "topic_id", val: this.topicId });
    }
  },

  destroyed() {
    this.resetState();
    this.selected_image = null;
  },

  methods: {
    ...mapActions("SlideSingle", [
      "storeData",
      "updateData",
      "resetState",
      "setValue",
      "fetchTopic",
      "newOption"
    ]),

    initRemoval(optionIndex) {
      this.optionToDelete = optionIndex;
      this.showDeleteConfirmation = true;
    },

    deleteOption() {
      const options = cloneDeep(this.item.options);
      options.splice(this.optionToDelete, 1);
      this.setValue({ key: "options", val: options });
    },

    updateIsQuestion(value) {
      this.setValue({ key: "is_question", val: value });
    },

    // sorry, I'm kinda lazy.
    // I know you're wondering about the weird architecture, but I just wanted to make it possible to have different options, with any weird kinda key. Also maybe make it possible in the future to select more than one answer

    updateOption(index, key, val) {
      const options = cloneDeep(this.item.options);
      if ((key === "is_answer") & val) {
        //   make sure all other options ahve is_answer set to 0
        options.map(option => {
          option.is_answer = 0;
        });
      }
      options[index][key] = val;
      this.setValue({ key: "options", val: options });
    },

    updateBody(value) {
      this.setValue({ key: "body", val: value });
    },

    // for use only with native input elements
    updateInput(event, key) {
      this.setValue({ key, val: event.target.value });
    },
    submitForm() {
      this.item.id
        ? this.updateData()
            .then(() => {
              this.$router.go(-1);
              this.$eventHub.$emit("update-success");
            })
            .catch(error => {
              console.error(error);
            })
        : this.storeData()
            .then(() => {
              this.$router.go(-1);
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