<template>
    <div>
        <div uk-sortable="handle: .uk-drag">
            <slider-item v-for="slide in items" :slide="slide" :key="slide.id"></slider-item>
        </div>
        <div title="Новый слайд" class="uk-button uk-button-secondary uk-margin-small uk-width-1-1" @click="addSlide">
            <span uk-icon="icon: plus; ratio: 2"></span>
        </div>
    </div>
</template>

<script>
    import SliderItem from "./SliderItem";

    export default {
        name: "slider",
        components: {SliderItem},
        data(){
            return {
                items: [
                    {
                        id: 1,
                        ordering: 1,
                        title: 'Слайд 1',
                        description: 'Описание 1',
                        link: '#',
                        image: 'https://canada4u.com.ua/images/about-canada/canada_blog6.jpg'
                    }
                ]
            }
        },
        methods: {
            addSlide(){
                this.items.push(
                    {
                        id: 0,
                        ordering: this.items[this.items.length - 1].ordering + 1,
                        title: 'Новый слайд #',
                        description: '',
                        link: '',
                        image: ''
                    });
            }
        }
    }
</script>

<style scoped>

</style>
