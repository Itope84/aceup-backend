function initialState() {
    return {
        all: [],
        // query: {},
        meta: {},
        loading: false
    }
}

const getters = {
    courses: state => {
        let rows = state.all

        // if (state.query.sort) {
        //     rows = _.orderBy(state.all, state.query.sort, state.query.order)
        // }

        // return rows.slice(state.query.offset, state.query.offset + state.query.limit)
        return rows
    },
    meta:         state => state.meta,
    loading:       state => state.loading
}

const actions = {
    fetchData({ commit, state }, page = 1) {
        commit('setLoading', true)

        axios.get(`courses?page=${page}`)
            .then(response => {
                commit('setAll', response.data.data)
                commit("setMeta", response.data.meta)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    destroyData({ commit, state }, id) {
        axios.delete('courses/' + id)
            .then(response => {
                commit('setAll', state.all.filter((item) => {
                    return item.id != id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
    },
    // setQuery({ commit }, value) {
    //     commit('setQuery', purify(value))
    // },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setAll(state, items) {
        state.all = items
    },
    setMeta(state, meta) {
        state.meta = meta
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    setQuery(state, query) {
        state.query = query
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
