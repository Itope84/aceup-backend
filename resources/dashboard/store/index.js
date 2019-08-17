import Vue from 'vue'
import Vuex from 'vuex'
import Alert from './modules/alert'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'
export default new Vuex.Store({
    modules: {
        Alert
    },
    strict: debug,
})
