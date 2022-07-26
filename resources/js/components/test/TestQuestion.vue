<template>
    <div class="uk-card uk-card-default uk-margin-bottom">
        <div class="uk-card-header">
            <input v-if="data.edit.type === 'question' && data.edit.id === question.id" v-model="question.text"
                   class="uk-input uk-form-blank uk-width-auto" @blur="update" @keyup.enter="update" type="text">
            <span v-else class="uk-margin-left">{{ question.text }} <a class="uk-link-text" @click="setEdit(question)" uk-icon="pencil"></a></span>
            <div class="uk-float-right uk-flex">
                <ul class="uk-iconnav">
                    <li><a class="uk-drag" uk-tooltip="Перетащить для изменения порядка вопросов" uk-icon="icon: move"></a></li>
                    <li v-if="question.variants.length < 1"><a @click="remove(question)" uk-tooltip="Удалить вопрос (если удалены ответы)" uk-icon="icon: trash"></a></li>
                </ul>
            </div>
        </div>
        <div class="uk-card-body">
            <transition-group name="list" mode="out-in" tag="div" uk-sortable="handle: .uk-drag">
                <test-variant :question="question" :variant="variant" v-for="variant of question.variants" :key="variant.id"></test-variant>
            </transition-group>
            <button @click="addVariant(question)" uk-tooltip="Добавить вариант ответа"
                    class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">
                <span uk-icon="plus"></span>
            </button>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import TestVariant from "./TestVariant";
    export default {
        name: "TestQuestion",
        components: {TestVariant},
        props: {
            question: {
                type: Object,
                required: true
            }
        },
        computed: {
            ...mapGetters({
                data: "test/data"
            })
        },
        methods: {
            ...mapActions({
                stopEdit: "test/stopEdit",
                addVariant: "test/addVariant",
                updateQuestion: "test/updateQuestion",
                remove: "test/removeQuestion"
            }),
            setEdit(question){
                this.data.edit.type = 'question';
                this.data.edit.id = question.id;
            },
            update(){
                this.stopEdit();
                let data = {"_token": this.$root.$data.token, "text": this.question.text, "id": this.question.id}
                this.updateQuestion(data);
            }
        }
    }
</script>

<style scoped>

</style>
