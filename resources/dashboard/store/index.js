import Vue from 'vue'
import Vuex from 'vuex'
import Alert from './modules/alert'
import CourseSingle from './modules/courses/single'
import CourseIndex from './modules/courses'
import TopicIndex from './modules/topics'
import TopicSingle from './modules/topics/single'
import SlideIndex from './modules/slides'
import SlideSingle from './modules/slides/single'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'
export default new Vuex.Store({
    modules: {
        Alert,
        CourseSingle,
        CourseIndex,
        TopicIndex,
        TopicSingle,
        SlideIndex,
        SlideSingle
    },
    strict: debug,
})
