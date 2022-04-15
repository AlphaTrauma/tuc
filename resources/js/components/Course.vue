<template>
    <div class="uk-card uk-card-small uk-card-default uk-margin-small-bottom">
        <div class="uk-card-body">
            <div class="uk-card-title">
                {{ course.title }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Course",
        props: {
            course: {
                required: true,
                type: Object
            }
        }
    }
</script>

<style scoped>

</style>
