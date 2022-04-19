<template>
    <transition name="fade">
        <div class="uk-card uk-card-default uk-card-small uk-margin">
            <div class="uk-card-media-top">
                <div class="js-upload uk-flex uk-flex-middle uk-flex-center uk-height-medium uk-width-expand uk-transition-toggle uk-background-cover"
                     tabindex="-1" :style="`background-image: url(${slide.image.filepath})`">
                    <div class="uk-position-left uk-overlay uk-overlay-default uk-card-body uk-transition-fade uk-height-1-1 uk-flex uk-flex-middle">
                        <div class="uk-text-large"><b>{{ slide.ordering }}</b></div>
                    </div>
                    <div class="uk-card uk-overlay uk-overlay-default uk-card-body uk-transition-fade">
                        <form class="uk-width-large uk-text-center" enctype="multipart/form-data" method="POST"
                              :action="slide.id ? `/dashboard/slider/${slide.id}` : '/dashboard/slider'">
                            <div class="uk-grid-small uk-flex-middle uk-margin-small-bottom" uk-grid>
                                <div class="uk-width-3-5">
                                    <input class="uk-input uk-form-small" name="link" @input="edit = true" required placeholder="Ссылка" :value="slide.link">
                                </div>
                                <div class="uk-width-2-5" uk-form-custom>
                                    <input type="file" accept=".png, .jpg, .jpeg" name="file" @change="uploadImage">
                                    <a class="uk-link uk-button uk-button-small uk-button-text">Изображение<span uk-icon="icon: cloud-upload" class="uk-margin-left"></span></a>
                                </div>
                            </div>
                            <input @input="edit = true" class="uk-input uk-form-small uk-margin-small-bottom" name="title" placeholder="Заголовок" :value="slide.title">
                            <input @input="edit = true" class="uk-input uk-form-small uk-margin-small-bottom" name="description" placeholder="Описание" :value="slide.description">
                            <input type="hidden" name="ordering" :value="slide.ordering">
                            <input type="hidden" name="_token" :value="token">
                            <transition name="fade">
                                <button v-if="edit" type="submit" class="uk-button uk-button-small uk-width-1-1 uk-button-success">
                                    <span class="uk-margin-small-right" uk-icon="check"></span>Сохранить
                                </button>
                            </transition>
                        </form>
                    </div>
                    <div class="uk-position-right uk-overlay uk-overlay-default uk-card-body uk-transition-fade uk-height-1-1 uk-flex uk-flex-middle">
                        <ul class="uk-iconnav uk-iconnav-vertical">
                            <li><a @click.prevent="remove(slide)" title="Удалить слайд" class="uk-text-danger" href="#" uk-icon="icon: close; ratio: 2"></a></li>
                            <li><a title="Перетащить слайд" class="uk-drag" href="#" uk-icon="icon: move; ratio: 2"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import _debounce from 'lodash';
    import {mapActions} from 'vuex';
    export default {
        name: "SliderItem",
        props: {
            slide: {
                required: true,
                type: Object
            }
        },
        mounted(){
            this.token = this.$root.$data.token;
            if(!this.slide.id) this.edit = true;
            this.slide.image.filepath = this.slide.id ? `/${this.slide.image.filepath}` : '/images/image-not-found.png';
        },
        data(){
            return {
                token: null,
                edit: false
            }
        },
        methods: {
            ...mapActions({
                remove: 'slider/remove',
                message: 'alerts/add',
                create: 'slider/create',
            }),
            uploadImage(e){
                let file = e.target.files[0];
                if (file) {
                    if(file.type.split('/')[0] === 'image') this.slide.image.filepath = URL.createObjectURL(file);
                    this.edit = true;
                } else {
                    this.message({type: 'danger', message: 'Ошибка при загрузке файла'})
                }
            },
            whereAmI(){
                this.slide.ordering = this.getIndex(this.$el) + 1;
            }
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s ease-out;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
