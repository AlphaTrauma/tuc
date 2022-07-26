<template>
    <div class="uk-container">
        <test-data></test-data>
        <transition-group name="list" mode="out-in" tag="div">
            <test-question v-for="question of questions" :question="question" :key="question.id"></test-question>
        </transition-group>
        <button @click="addQuestion" uk-tooltip="Добавить вопрос" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">
            <span uk-icon="plus"></span>
        </button>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    import TestQuestion from "./TestQuestion";
    import TestData from "./TestData";
    export default {
        name: "TestContainer",
        components: {TestQuestion, TestData},
        computed: {
            ...mapGetters({
                data: "test/data",
                questions: "test/questions"
            })
        },
        methods: {
            ...mapActions({
                load: "test/load",
                add: "test/addQuestion"
            }),
            addQuestion(){
                this.add(this.data.id);
            }
        },
        mounted(){
            this.load();
        }
    }
</script>

<style scoped>

</style>
