const optionFormat = {
    key: null,
    body: null,
    is_answer: 0
};

function initialState() {
    return {
        item: {
            topic_id: null,
            body: null,
            index: null,
            id: null,
            options: [],
            is_question: 0
        },
        topic: null,
        loading: false
    };
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    // uploading: state => state.uploading
    topic: state => state.topic
};

const actions = {
    storeData({ commit, state, dispatch }) {
        commit("setLoading", true);
        dispatch("Alert/resetState", null, { root: true });

        return new Promise((resolve, reject) => {
            let params = new FormData();

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== "object" && !!fieldValue) {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== "object") {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            // remeber each is an object
                            for(let [key, value] of Object.entries(fieldValue[index])){
                                params.set(
                                    `${fieldName}[${index}][${key}]`,value
                                );
                            }
                            
                        }
                    }
                }
            }

            axios
                .post("/slides", params)
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
    resetState({ commit }) {
        commit("resetState");
    },
    updateData({ commit, state, dispatch }) {
        commit("setLoading", true);
        dispatch("Alert/resetState", null, { root: true });

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set("_method", "PUT");

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== "object" && !!fieldValue) {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== "object") {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            // remeber each is an object
                            for(let [key, value] of Object.entries(fieldValue[index])){
                                params.set(
                                    `${fieldName}[${index}][${key}]`,value
                                );
                            }
                            
                        }
                    }
                }
            }

            axios
                .post(`slides/${state.item.id}`, params)
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
        axios.get("slides/" + id).then(response => {
            commit("setItem", response.data.data);
        });
    },

    fetchTopic({ commit }, id) {
        axios.get("topics/" + id).then(response => {
            commit("setTopic", response.data.data);
        });
    },

    newOption({ commit, state }) {
        const options = [...state.item.options];
        
        // this is really stupid, please do the right thing and use an array of a-z jeje
        let key = String.fromCharCode(options.length + 65)
        options.push({...optionFormat, key: key});
        commit("setValue", {key: "options", val: options });
    },

    setItem({ commit }, val) {
        commit("setItem", val);
    },

    // Emi ika
    setValue({ commit }, { key, val }) {
        commit("setValue", { key, val });
    }
};

const mutations = {
    setItem(state, item) {
        state.item = item;
    },
    setTopic(state, data) {
        state.topic = data;
    },
    setLoading(state, loading) {
        state.loading = loading;
    },
    resetState(state) {
        state = Object.assign(state, initialState());
    },

    setValue(state, { key, val }) {
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
