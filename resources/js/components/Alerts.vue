<template>
    <div v-if="alerts.length > 0" class="uk-padding uk-position-bottom uk-position-fixed">
        <transition-group name="list" tag="div">
            <alert v-for="alert in alerts" :alert="alert" :key="alert.key" class="list-item"></alert>
        </transition-group>
    </div>
</template>

<script>
    import alert from './Alert';
    import {mapGetters} from 'vuex';
    export default {
        name: "Alerts",

        components: {alert},
        computed: {
            ...mapGetters({
                alerts: 'alerts/alerts'
            })
        }
    }
</script>

<style scoped>
    .list-item {
        transition-property: transform, opacity;
        transition: 0.5s ease-out;
    }
    .list-enter, .list-leave-to {
        opacity: 0;
        transform: translateY(30px);
    }
</style>
