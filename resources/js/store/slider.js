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
        },
        create(state, payload){
            state.last++;
            state.slides.push({
                id: payload,
                ordering: state.last,
                title: null,
                description: null,
                link: '#',
                image: null
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
        async update({commit}, payload){
            if(payload.link && payload.image){
                const response = await axios.post(`/dashboard/slider/${payload.id}`, payload)
                commit('update', {item: payload, response: response});
            }
        },
        async updateImage({commit}, payload){
            axios.post(`/dashboard/slider/image`, {id: payload.slide.id, image: payload.image}).then((response) => {
                console.log(response.data);
                commit('updateImage', {response: response, payload: payload.slide});
            });

        },
        async create({commit}, payload) {
            const response = await axios.post('/dashboard/slider', {ordering: payload});
            commit('create', response);
        },
        async remove({commit}, payload) {
            const response = await axios.delete(`/dashboard/slider/${payload.id}`);
            if(response.status) commit('remove', payload);
        },
        count({commit}) {
            commit('count');
        }
    }
}
