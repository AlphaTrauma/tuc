<template>
    <div class="uk-margin">
        <vue-editor class="uk-background-default"
                    @editor-updated="handle"
                    v-model="html"
                    :useSaveButton="false"
                    :editor-toolbar="customToolbar"
                    :use-custom-image-handler="true"
                    @image-added="handleImageAdded"
                    @image-removed="handleImageRemoved"
                    placeholder="Текст">
        </vue-editor>
        <input type="hidden" name="html" :value="html">
    </div>
</template>

<script>
    import { VueEditor } from "vue2-editor";
    import { mapActions } from 'vuex';

    export default {
        components: {
            VueEditor
        },
        props: {
            content: {
                required: false,
                type: String
            },
            image: {
                required: false,
                type: String,
                default: ''
            }
        },
        mounted(){
            this.html = this.$props.content;
        },
        data(){
          return {
              html: '',
              customToolbar: [
                  ["bold", "italic", "underline", "strike"],
                  [{ 'header': 2 }, { 'header': 3 }],
                  [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
                  ['blockquote'],
                  [{ 'color': [] }, { 'background': [] }],
                  [{ list: "ordered" }, { list: "bullet" }],
                  ["link", this.$props.image]
              ]
          }
        },
        methods: {
            ...mapActions({
                message: 'alerts/add'
            }),
            handle(value){
                this.html = value
            },
            handleImageAdded: function(file, Editor, cursorLocation, resetUploader){
                let formData = new FormData();
                formData.append("image", file);

                axios({
                    url: 'append',
                    method: "POST",
                    data: formData
                }).then(result => {
                        if(result.data){
                            let url = result.data.filepath;
                            Editor.insertEmbed(cursorLocation, "image", url);
                            resetUploader();
                        } else {
                            this.message({type: 'danger', message: 'Ошибка при загрузке файла'})
                        }
                }).catch(err => {
                    this.message({type: 'danger', message: 'Ошибка при загрузке файла'})});
            },
            handleImageRemoved: function(file){
                let formData = new FormData();
                formData.append("filepath", file);
                axios({
                    url: 'remove',
                    method: 'POST',
                    data: formData
                })

                this.message({type: 'success', message: 'удалено'})
            }
        }
    };
</script>

<style scoped>

</style>
