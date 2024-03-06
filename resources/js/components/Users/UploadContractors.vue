<template>
    <div>
        <form :action="group ? `/contractors/${id}/upload/${group}` : `/contractors/${id}/upload`" ref="form" method="post" enctype="multipart/form-data">
            <slot></slot>
            <a @click="upload" class="uk-button uk-button-success">{{ group ? 'Дополнить группу' : 'Импортировать пользователей' }}</a>
            <input ref="file" type="file" name="file" class="uk-hidden" @change="submit">
        </form>
    </div>
</template>

<script>
    export default {
        name: "UploadContractors",
        props: {
            id: {
                type: Number,
                required: true
            },
            group: {
                type: Number,
                required: false
            }
        },
        methods: {
            upload(){
                this.$refs.file.click();
            },
            submit(){
                this.$refs.form.submit();
            }
        }
    }
</script>

<style scoped>

</style>
