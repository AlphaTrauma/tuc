export default {
    namespaced: true,
    state: {
        alerts: [],
        index: 0
    },
    getters: {
        alerts(state){
            return state.alerts;
        }
    },
    mutations: {
        add(state, payload){
            payload.key = ++state.index;
            if(state.alerts.length > 2) state.alerts.pop();
            state.alerts.unshift(payload);
            setTimeout(() => state.alerts.splice(state.alerts.indexOf(payload), 1), 3000);
        }
    },
    actions: {
        add({commit}, payload){
            commit('add', payload);
        }
    }
}
