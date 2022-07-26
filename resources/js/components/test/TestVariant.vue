<template>
    <div class="uk-card uk-card-default uk-card-body uk-card-small uk-margin-small-bottom"
         :class="{'correct-background': question.correct === variant.id}">

        <label v-if="question.correct === variant.id">
            <input checked class="uk-radio" type="radio" :name="`${question.id}-variant`">
        </label>
        <label v-else>
            <input @change="setCorrect" class="uk-radio" type="radio" :name="`${question.id}-variant`">
        </label>
        <input v-if="data.edit.type === 'variant' && data.edit.id === variant.id" v-model="variant.text" @blur="update" @keyup.enter="update"
               class="uk-input uk-form-blank uk-width-auto" type="text">
        <span v-else class="uk-margin-left">{{ variant.text }} <a @click="setEdit(variant)" class="uk-link-text" uk-icon="pencil"></a></span>
        <div class="uk-float-right uk-flex">
            <ul class="uk-iconnav">
                <li><a class="uk-drag" uk-tooltip="Перетащить для изменения порядка ответов" uk-icon="icon: move"></a></li>
                <li><a @click="remove({item: variant, question: question})" uk-tooltip="Удалить" uk-icon="icon: trash"></a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "TestVariant",
        props: {
            question: {
                required: true,
                type: Object
            },
            variant: {
                required: true,
                type: Object
            }
        },
        methods: {
            ...mapActions({
                stopEdit: "test/stopEdit",
                remove: "test/removeVariant",
                updateVariant: "test/updateVariant",
                sendCorrect: "test/sendCorrect"
            }),
            setEdit(variant){
                this.data.edit.type = 'variant';
                this.data.edit.id = variant.id;
            },
            update(){
                this.stopEdit();
                let data = {"_token": this.$root.$data.token, "text": this.variant.text, "id": this.variant.id}
                this.updateVariant(data);
            },
            setCorrect(){
                this.sendCorrect({question: this.question, variant: this.variant.id});
            }
        },
        computed: {
            ...mapGetters({
                data: "test/data"
            })
        }
    }
</script>

<style scoped>

</style>
