function initialState() {
    return {
        item: {
            title: null,
            description: null,
            featured_image: null,
            color_scheme: null,
            id: null
        },
        uploading: false,
        loading: false
    };
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    uploading: state => state.uploading
    // modulesAll: state => state.modulesAll
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
                .post("/courses", params)
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
                .post(`courses/${state.item.id}`, params)
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
    resetState({commit}) {
        commit("resetState")
    },
    fetchData({ commit, dispatch }, id) {
        axios.get("courses/" + id).then(response => {
            commit("setItem", response.data.data);
        });
    },

    setCourse({ commit }, course) {
        commit("setItem", course);
    },

    setTitle({ commit }, title) {
        commit("setTitle", title);
    },

    setDescription({ commit }, desc) {
        commit("setDescription", desc);
    },

    setFeatured_image({ commit, dispatch }, image) {
        // upload file
        commit("setUploading", true)
        
        const file = new FormData();
        file.append("image", image);
        axios
            .post("upload-image", file)
            .then(response => {
                commit("setFeaturedImage", response.data.data);
            })
            .catch(error => {
                let message = error.response.data.message || error.message;
                let errors = error.response.data.errors;
                dispatch(
                    "Alert/setAlert",
                    {
                        message: message,
                        errprs: errors,
                        color: "danger"
                    },
                    { root: true }
                );
            })
            .finally(() => {
                commit("setUploading", false)
            });
    },

    setColor_scheme({ commit }, color) {
        commit("setColor_scheme", color);
    }
};

const mutations = {
    setItem(state, item) {
        state.item = item;
    },
    setLoading(state, loading) {
        state.loading = loading;
    },
    setUploading(state, loading) {
        state.uploading = loading;
    },
    resetState(state) {
        state = Object.assign(state, initialState());
    },

    setTitle(state, title) {
        state.item.title = title;
    },

    setDescription(state, desc) {
        state.item.description = desc;
    },

    setFeaturedImage(state, url) {
        state.item.featured_image = url;
    },

    setColor_scheme(state, color) {
        state.item.color_scheme = color;
    }
};

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
};
