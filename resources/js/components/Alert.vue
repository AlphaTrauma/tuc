<template>
    <div class="uk-border-rounded uk-box-shadow-medium uk-text-center uk-margin-small-bottom uk-alert" :class="`uk-alert-${alert.type}`">
        <a class="uk-alert-close" uk-close></a>
        <p><b><span class="uk-margin-right" :uk-icon="`icon: ${alert.type === 'danger' ? 'warning' : 'info'}`"></span>{{ alert.message}} </b></p>
    </div>
</template>

<script>
    export default {
        name: "Alert",
        props: {
            alert: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
