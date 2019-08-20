<template>
    <div class="row row-alert" v-if="message">
        <div class="col-xs-6">
            <div class="alert alert-dismissible" :class="'alert-' + color">
                <button class="btn btn-transparent rounded-circle btn-cancel" @click="resetState"><i class="fas fa-times"></i></button>
                <h5>
                    <i class="icon fa fa-check" v-if="color == 'success'"></i>
                    <i class="icon fa fa-ban" v-if="color == 'danger'"></i>
                    {{ message }}
                </h5>
                <ul v-if="errors">
                    <li v-for="(value, key) in errors" :key="key">
                        {{ value[0] }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'
// Make this work!
export default {
    name: "BootstrapAlert",
    data() {
        return {
            // Code...
        }
    },
    computed: {
        ...mapGetters('Alert', ['message', 'errors', 'color'])
    },
    created() {
        // Code...
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
        }
    },
    methods: {
        ...mapActions('Alert', ['resetState'])
    }
}
</script>


<style scoped>
.row-alert {
    padding: 10px;
}

h5 {
    font-size: 1rem;
}

.row.row-alert {
        position: fixed;
    bottom: 10px;
    right: 10px;
    z-index: 100;
}

.btn-cancel {
    position: absolute;
    right: 0;
    top: 0;
    color: inherit;
}
</style>
