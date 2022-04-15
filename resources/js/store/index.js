import Vue from 'vue';
import Vuex from 'vuex';


import slider from './slider';
import alerts from './alerts'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        slider,
        alerts
    }
});
