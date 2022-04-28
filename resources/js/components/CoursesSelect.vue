<template>
    <div>
        <multiselect v-model="value" :options="options" :multiple="true"
                     placeholder="Добавить список курсов" :group-select="true" no-result="По данному запросу совпадений нет"
                     no-options="Курсы не найдены" select-label="Выбрать курс" selected-label="Выбран" deselect-label="Убрать"
                     deselect-group-label="Убрать направление" select-group-label="Выбрать всё направление"
                     group-values="courses" group-label="title"  track-by="id" label="title"
        ></multiselect>
        <select hidden multiple name="courses[]" id="courses">
            <option v-for="item in value" :value="item.id" selected>{{ item.title}}</option>
        </select>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "CoursesSelect",
        components: {Multiselect},
        props: {
            'id': {
                type: Number,
                required: true
            }
        },
        data() {
            return {
                value: [],
                options: []
            }
        },
        mounted(){
            axios.get(`/dashboard/courses/${this.$props.id}/data`).then(response => {
                this.options = response.data.options;
                this.value = response.data.selected;
            });
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

</style>
