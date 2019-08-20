import Vue from 'vue'
import Vuex from 'vuex'
import Alert from './modules/alert'
import CourseSingle from './modules/courses/single'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'
export default new Vuex.Store({
    modules: {
        Alert,
        CourseSingle
    },
    strict: debug,
})
