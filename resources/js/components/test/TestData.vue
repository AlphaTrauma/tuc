<template>
    <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
        <h2>
            <input v-if="data.edit.type === 'title'" type="text" v-model="data.title" @blur="update" @keyup.enter="update"
                   class="uk-input uk-width-auto">
            <span v-else>{{ data.title }} <a class="uk-link-text" @click="data.edit.type = 'title'" uk-icon="pencil"></a></span>
        </h2>
        <p>
            <input v-if="data.edit.type === 'description'" type="text" v-model="data.description" @blur="update" @keyup.enter="update"
                   class="uk-input uk-width-auto">
            <span v-else>{{ data.description }} <a class="uk-link-text" @click="data.edit.type = 'description'" uk-icon="pencil"></a></span>
        </p>
        <p class="uk-inline">
            <label uk-tooltip="Количество правильных ответов для прохождения, в процентах"><b>Порог:</b></label>
            <input v-if="data.edit.type === 'threshold'" type="number" v-model="data.threshold" @blur="update" @keyup.enter="update"
                   class="uk-input uk-width-auto">
            <span v-else>{{ data.threshold }} %<a class="uk-link-text" @click="data.edit.type = 'threshold'" uk-icon="pencil"></a></span>
        </p>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from "vuex";
    export default {
        name: "TestAnswer",
        computed: {
            ...mapGetters({
                data: "test/data"
            })
        },
        methods: {
            ...mapActions({
                stopEdit: "test/stopEdit",
                updateData: "test/updateData"
            }),
            update(){
                this.stopEdit();
                let data = {"_token": this.$root.$data.token, "id": this.data.id, "title": this.data.title,
                    "description": this.data.description, "threshold": this.data.threshold}
                this.updateData(data);
            }
        }
    }
</script>

<style scoped>

</style>
