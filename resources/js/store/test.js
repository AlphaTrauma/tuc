export default {
    namespaced: true,
    state: {
        data: {
            id: null,
            title: '',
            description: '',
            threshold: null,
            edit: {
                type: null,
                id: null
            }
        },
        questions: [],
    },
    getters: {
        questions(state){
            return state.questions;
        },
        data(state){
            return state.data;
        }
    },
    mutations: {
        load(state, payload){
            state.questions = payload.test.questions ? payload.test.questions : [];
            state.data.id = payload.test.id;
            state.data.title = payload.test.title;
            state.data.threshold = payload.test.threshold;
            state.data.description = payload.test.description;
        },
        addQuestion(state, payload){
            payload.variants = [];
            state.questions.push(payload);
        },
        removeQuestion(state, payload){
            state.questions.splice(state.questions.indexOf(payload), 1);
        },
        addVariant(state, payload){
            if(!payload.variants) payload.variants = [];
            payload.variants.push(payload.result);
        },
        removeVariant(state, payload){
            payload.question.variants.splice(payload.question.variants.indexOf(payload.item), 1);
        },
        sendCorrect(state, payload){
            payload.question.correct = payload.variant;
        },
        stopEdit(state){
            state.data.edit.type = state.data.edit.id = null;
        }
    },
    actions: {
        async load({commit}){
            const response = await axios.get('');
            commit('load', response.data);
        },
        async updateData({commit}, payload){
            const response = await axios.post(`/dashboard/test/${payload.id}/update`, payload);
        },
        async addQuestion({commit}, id){
            const response = await axios.get(`/dashboard/test/${id}/add`);
            commit('addQuestion', response.data);
        },
        async updateQuestion({commit}, payload){
            await axios.post(`/dashboard/question/${payload.id}/update`, payload);
        },
        async removeQuestion({commit}, payload){
            const response = await axios.get(`/dashboard/question/${payload.id}/delete`);
            if(response.data) commit('removeQuestion', payload);
        },
        async addVariant({commit}, question){
            const response = await axios.get(`/dashboard/question/${question.id}/add`);
            commit('addVariant', {variants: question.variants, result: response.data});
        },
        async updateVariant({commit}, payload){
            await axios.post(`/dashboard/variant/${payload.id}/update`, payload);
        },
        async removeVariant({commit}, payload){
            const response = await axios.get(`/dashboard/variant/${payload.item.id}/delete`);
            if(response.data) commit('removeVariant', payload);
        },
        async sendCorrect({commit}, payload){
            const response = await axios.post(`/dashboard/question/${payload.question.id}/set_correct`, {variant: payload.variant});
            if(response.data) commit('sendCorrect', payload);
        },
        stopEdit({commit}){
            commit('stopEdit');
        }
    }
}
