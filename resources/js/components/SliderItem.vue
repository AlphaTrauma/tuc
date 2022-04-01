<template>
    <div class="uk-card uk-card-default uk-card-small uk-margin">
        <div class="uk-card-media-top">
            <div class="js-upload uk-placeholder uk-flex uk-flex-middle uk-flex-center uk-height-medium uk-width-expand uk-transition-toggle" tabindex="-1" :style="`background-image: url(${slider.image})`">
                <div class="uk-card uk-overlay uk-overlay-default uk-card-body uk-transition-fade">
                    <span class="uk-text-middle">Перетащите сюда изображение, чтобы загрузить, или</span>
                    <div uk-form-custom>
                        <input type="file">
                        <span class="uk-link">нажмите здесь <span uk-icon="icon: cloud-upload"></span></span>
                    </div>
                    <p><span uk-icon="icon: pencil"></span> {{ slider.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SliderItem",
        props: {
            slider: {
                required: true,
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>
