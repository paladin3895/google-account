import _ from 'lodash';
import axios from 'axios'
import config from '../config'

const api = axios.create({
  baseURL: config.api,
});

// initial state
const state = {
    user: null,
    routes: {},
    config: {},
    notifications: [],
    modalShow: false,
    timestamp: Date.now(),
}


// getters
const getters = {
    user: (state) => state.user,
    notifications: (state) => state.notifications,
    timestamp: (state) => state.timestamp,
    modalShow: (state) => state.modalShow,

    // helper function to get config
    config: (state) => (key, defaultValue = null) => {
        return _.get(state, ['config', key], defaultValue);
    },
    // helper function to get route
    route: (state) => (name, params) => {
        let path = '/' + _.get(state, ['routes', name]);

        _.forEach(params, (value, key) => {
            path = _.replace(path, new RegExp(`{${key}[?]?}`), value);
        })

        return path;
    }
}

const actions = {
    openModal({ commit }) {
        commit('setModal', true);
    },

    hideModal({ commit }) {
        commit('setModal', false);
    },
}

// mutations
const mutations = {
    setModal(state, value) {
        state.modalShow = Boolean(value);
    }
}

export default {
    state,
    getters,
    actions,
    mutations,
}
