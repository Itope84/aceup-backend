function initialState() {
    return {
        item: {
            title: null,
            course_id: null,
            introduction: null,
            index: null,
            id: null
        },
        courses: [],
        loading: false
    };
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    // uploading: state => state.uploading
    courses: state => state.courses
};

const actions = {
    storeData({ commit, state, dispatch }) {
        commit("setLoading", true);
        dispatch("Alert/resetState", null, { root: true });

        return new Promise((resolve, reject) => {
            let params = new FormData();

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== "object") {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== "object") {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(
                                fieldName + "[" + index + "]",
                                fieldValue[index]
                            );
                        }
                    }
                }
            }

            axios
                .post("/topics", params)
                .then(response => {
                    commit("resetState");
                    resolve();
                })
                .catch(error => {
                    let message = error.response.data.message || error.message;
                    let errors = error.response.data.errors;

                    dispatch(
                        "Alert/setAlert",
                        { message: message, errors: errors, color: "danger" },
                        { root: true }
                    );

                    reject(error);
                })
                .finally(() => {
                    commit("setLoading", false);
                });
        });
    },
    resetState({commit}) {
        commit("resetState")
    },
    updateData({ commit, state, dispatch }) {
        commit("setLoading", true);
        dispatch("Alert/resetState", null, { root: true });

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set("_method", "PUT");

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== "object") {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== "object") {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(
                                fieldName + "[" + index + "]",
                                fieldValue[index]
                            );
                        }
                    }
                }
            }

            axios
                .post(`topics/${state.item.id}`, params)
                .then(response => {
                    commit("setItem", response.data.data);
                    resolve();
                })
                .catch(error => {
                    let message = error.response.data.message || error.message;
                    let errors = error.response.data.errors;

                    dispatch(
                        "Alert/setAlert",
                        { message: message, errors: errors, color: "danger" },
                        { root: true }
                    );

                    reject(error);
                })
                .finally(() => {
                    commit("setLoading", false);
                });
        });
    },
    fetchData({ commit, dispatch }, id) {
        axios.get("topics/" + id).then(response => {
            commit("setItem", response.data.data);
        });
    },

    fetchCourses({ commit }) {
        axios.get("courses").then(response => {
            commit("setCourses", response.data.data);
        });
    },

    setItem({ commit }, course) {
        commit("setItem", course);
    },

    // Emi ika
    setValue({ commit }, {key, val}) {
        commit("setValue", {key, val});
    }
};

const mutations = {
    setItem(state, item) {
        state.item = item;
    },
    setCourses(state, data) {
        state.courses = data;
    },
    setLoading(state, loading) {
        state.loading = loading;
    },
    resetState(state) {
        state = Object.assign(state, initialState());
    },

    setValue(state, {key, val}) {
        state.item[key] = val;
    }
};

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
};
