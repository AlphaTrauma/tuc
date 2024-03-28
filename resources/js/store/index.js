import Vue from 'vue';
import Vuex from 'vuex';


import slider from './slider';
import alerts from './alerts'
import test from './test';
import vehicles from "./vehicles";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        slider,
        alerts,
        test,
        vehicles
    }
});
