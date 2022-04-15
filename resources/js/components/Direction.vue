<template>
    <div class="uk-card uk-card-default uk-margin-bottom">
        <div class="uk-card-body">
            <div class="uk-card-title uk-text-center">{{ direction.title }}</div>
        </div>
        <div class="uk-card-body">
            <course v-for="course in direction.courses" :course="course" :key="course.id"></course>
        </div>
    </div>
</template>

<script>
    import Course from "./Course";
    export default {
        name: "Direction",
        components: {Course},
        props: {
            direction: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
