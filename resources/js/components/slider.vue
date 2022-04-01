<template>
    <div>
        <div uk-sortable="group: sortable-group">
            <slider-item v-for="slider in items" :slider="slider" :key="slider.id"></slider-item>
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
                        title: 'Слайд 1',
                        description: 'Описание 1',
                        button_text: 'Заказать',
                        link: '#',
                        image: 'https://canada4u.com.ua/images/about-canada/canada_blog6.jpg'
                    },
                    {
                        id: 2,
                        title: 'Слайд 2',
                        description: 'Описание 2',
                        button_text: 'Показать',
                        link: '#',
                        image: 'https://media.list.ly/production/782491/listly-top-5-things-to-do-in-colombo-how-to-explore-the-capital-city-of-the-island-country-to-your-heart-s-content-headline.jpeg'
                    },
                    {
                        id: 3,
                        title: 'Слайд 3',
                        description: 'Описание 3',
                        button_text: 'Показать',
                        link: '#',
                        image: 'https://c7.uihere.com/files/580/307/643/panorama-lake-panorama-mountain-panorama-reflection-panorama-thumb.jpg'
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
