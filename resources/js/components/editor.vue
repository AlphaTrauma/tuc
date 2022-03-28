<template>
    <div class="uk-margin">
        <vue-editor class="uk-background-default"
                    @editor-updated="handle"
                    :editor-content="content"
                    :useSaveButton="false"
                    :editor-toolbar="customToolbar"
                    placeholder="Текст страницы">
        </vue-editor>
        <input type="hidden" name="html" :value="html">
    </div>
</template>

<script>
    import { VueEditor } from "vue2-editor";

    export default {
        components: {
            VueEditor
        },
        props: ['content'],
        mounted(){
            this.html = this.$props.content;
        },
        data: () => ({
                         html: '',
                         customToolbar: [
                             ["bold", "italic", "underline", "strike"],
                             [{ 'header': 2 }, { 'header': 3 }],
                             [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
                             ['blockquote'],
                             [{ 'color': [] }, { 'background': [] }],
                             [{ list: "ordered" }, { list: "bullet" }],
                             ["link", "image"]
                         ]
        }),
        methods: {
            handle(value){
                this.html = value
            }
        }
    };
</script>

<style scoped>

</style>
