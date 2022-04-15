<template>
    <div>
        <direction v-for="direction in directions" :direction="direction" :key="direction.id"></direction>
    </div>
</template>

<script>
    import direction from "./Direction";
    export default {
        name: "Courses",
        components: {direction},
        data(){
            return {
                directions: [
                    {
                        id: 1,
                        title: 'Пожарная безопасность',
                        description: '',
                        courses: [
                            {
                                title: 'Действия в чрезвычайной ситуации',
                                hours: 22
                            },
                            {
                                title: 'Основы пожарной безопасности',
                                hours: 12
                            },
                            {
                                title: 'Пожарная безопасность при деревообработке',
                                hours: 30
                            }
                        ]
                    },
                    {
                        id: 2,
                        title: 'Безопасность труда',
                        description: '',
                        courses: [
                            {
                                title: 'Основы безопасности труда',
                                hours: 10
                            },
                            {
                                title: 'Безопасность труда для руководителей',
                                hours: 22
                            }
                        ]
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
