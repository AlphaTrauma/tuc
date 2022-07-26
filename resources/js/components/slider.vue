<template>
    <div>
        <div v-on:moved="getPosition()" uk-sortable="handle: .uk-drag">
             <slider-item class="slide" v-for="slide in slides" :slide="slide" :key="slide.id"></slider-item>
        </div>
        <div title="Новый слайд" class="uk-button uk-button-secondary uk-margin-small uk-width-1-1" @click="create(last)">
            <span uk-icon="icon: plus; ratio: 2"></span>
        </div>
    </div>
</template>

<script>
    import SliderItem from "./SliderItem";
    import {mapActions, mapGetters} from 'vuex';

    export default {
        name: "slider",
        components: {SliderItem},
        mounted(){
            this.load()
        },
        computed: {
            ...mapGetters({
                slides: 'slider/slides',
                last: 'slider/last'
                       })
        },
        methods: {
            ...mapActions({
                load: 'slider/load',
                create: 'slider/create'
            }),
            getPosition(){
                this.$children.forEach(el => {
                    setTimeout(el.whereAmI(), 500);
                })
            }
        }
    }
</script>

<style scoped>
</style>
