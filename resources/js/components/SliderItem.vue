<template>
    <div class="uk-card uk-card-default uk-card-small uk-margin">
        <div class="uk-card-media-top">
            <div class="js-upload uk-flex uk-flex-middle uk-flex-center uk-height-medium uk-width-expand uk-transition-toggle uk-background-cover"
                 tabindex="-1" :style="`background-image: url(${slide.image ? slide.image: '/images/image-not-found.png'})`">
                <div class="uk-position-left uk-overlay uk-overlay-default uk-card-body uk-transition-fade uk-height-1-1 uk-flex uk-flex-middle">
                    <div class="uk-text-large"><b>{{ slide.ordering }}</b></div>
                </div>
                <div class="uk-card uk-overlay uk-overlay-default uk-card-body uk-transition-fade">
                    <div class="uk-width-medium uk-text-center">
                        <div uk-form-custom>
                            <input type="file" @change="uploadImage">
                            <a class="uk-link uk-button uk-button-danger">Загрузить изображение<span uk-icon="icon: cloud-upload" class="uk-margin-left"></span></a>
                        </div>
                        <input class="uk-input uk-margin-small uk-form-small" placeholder="Ссылка" @change="update(slide)" v-model="slide.link">
                        <input class="uk-input uk-margin-small uk-form-small" placeholder="Заголовок" @change="update(slide)" v-model="slide.title">
                        <input class="uk-input uk-margin-small uk-form-small" placeholder="Описание" @change="update(slide)" v-model="slide.description">
                    </div>
                </div>
                <div class="uk-position-right uk-overlay uk-overlay-default uk-card-body uk-transition-fade uk-height-1-1 uk-flex uk-flex-middle">
                    <ul class="uk-iconnav uk-iconnav-vertical">
                        <li><a title="Удалить слайд" class="uk-text-danger" href="#" uk-icon="icon: close; ratio: 2"></a></li>
                        <li><a title="Перетащить слайд" class="uk-drag" href="#" uk-icon="icon: move; ratio: 2"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _debounce from 'lodash';
    export default {
        name: "SliderItem",
        props: {
            slide: {
                required: true,
                type: Object
            }
        },
        data(){
            return {
                edit: null
            }
        },
        methods: {
            uploadImage(e){
                let image = e.target.files[0], reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.slide.image = e.target.result;
                };
            },
            update(slide){
                _debounce(alert(slide.link), 500);
            }
        }
    }
</script>

<style scoped>

</style>
