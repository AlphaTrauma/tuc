export default {
    namespaced: true,
    state: {
        slides: [],
        last: 0,
    },
    getters: {
        slides(state){
            return state.slides;
        },
        last(state){
            return state.last;
        }
    },
    mutations: {
        load(state, payload) {
            state.slides = payload;
            state.last = state.slides.length === 0 ? 0 : Math.max.apply(Math, state.slides.map(el => el.ordering));
        },
        remove(state, payload){
            state.slides.splice(state.slides.indexOf(payload), 1);
            state.last--;
        },
        create(state){
            state.last++;
            state.slides.push({
                id: null,
                ordering: state.last,
                title: null,
                description: null,
                link: null,
                image: {filepath: ''}
            });
        },
        update(state, payload){
            payload.item = payload.response;
        },
        updateImage(state, payload){
            payload.image = payload.response;
        }
    },
    actions: {
        async load({commit}) {
            const response = await axios.get(`/dashboard/slider`);
            commit('load', response.data);
        },
        async create({commit}) {
            commit('create');
        },
        async remove({commit}, payload) {
            if(payload.id) await axios.delete(`/dashboard/slider/${payload.id}`);
            commit('remove', payload);
        },
        count({commit}) {
            commit('count');
        }
    }
}
