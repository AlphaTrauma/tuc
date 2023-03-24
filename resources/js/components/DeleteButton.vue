<template>
    <li>
        <transition name="fade" mode="out-in">
            <a key="1" v-if="active" class="uk-text-danger" @click.prevent="execute" uk-tooltip="Подтвердить действие" uk-icon="icon: check"></a>
            <a key="2" v-else :uk-tooltip="text" uk-icon="icon: close" @click.prevent="active = true"></a>
        </transition>
    </li>
</template>

<script>
    export default {
        name: "DeleteButton",
        props: {
            text: {
                type: String,
                required: true
            },
            action: {
                type: String,
                required: true
            },
            async: {
                type: Boolean,
                required: false,
                default: false
            },
            onSuccess: {
                type: Function,
                required: false
            }
        },
        data(){
            return {
                active: false
            }
        },
        methods: {
            execute(){
                if(this.async){
                    axios.get(this.action).then(response => {
                        this.onSuccess();
                    })
                } else {
                    window.open(this.action, '_self')
                }

            }
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s ease-out;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
