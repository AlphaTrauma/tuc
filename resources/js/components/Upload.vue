<template>
    <div>
        <div v-if="!isImage && file" class="uk-padding-small uk-text-center">Файл: {{ filename }}</div>
        <div class="uk-position-relative uk-text-center" style="min-height: 100px;">
            <img v-if="preview" :data-src="preview" alt="Изображение" uk-img>
            <div class="uk-card-body uk-position-absolute uk-position-center">
                <div class="uk-placeholder uk-text-center uk-card-default uk-overlay-default">
                    <div uk-form-custom>
                        <input v-on:change="getFile" name="file" type="file">
                        <div class="uk-button uk-button-default"><span class="uk-margin-small-right" uk-icon="icon: cloud-upload"></span>Загрузить файл</div>
                    </div>

                </div>
            </div>
            <div v-if="isImage" class="uk-overlay uk-overlay-default uk-padding-small uk-position-bottom uk-text-center">
                <p>{{ filename }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    export default {
        name: "Upload",
        props: {
            image: {
                required: false,
                type: String
            }
        },
        data(){
            return {
                file: null,
                filename: null,
                preview: null,
                isImage: false,
                size: null,
            }
        },
        mounted() {
            if (this.$props.image) this.preview = this.$props.image;
        },
        methods: {
            ...mapActions({
                message: 'alerts/add'
            }),
            getFile(e) {
                this.file = e.target.files[0];
                if (this.file) {
                    this.filename = this.file.name;
                    if(this.file.type.split('/')[0] === 'image') {
                        this.preview = URL.createObjectURL(this.file)
                        this.isImage = true;
                    } else {
                        this.preview = '';
                        this.isImage = false;
                    }
                } else {
                    this.message({type: 'danger', message: 'Ошибка при загрузке файла'})
                }
            }
        }
    }
</script>

<style scoped>
    img {
        max-height: 350px;
        width: auto;
    }
</style>
