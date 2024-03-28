<template>
    <div>
        <form hidden :action="group ? `/contractors/${id}/upload/${group}` : `/contractors/${id}/upload`" ref="form" method="post" enctype="multipart/form-data">
            <slot></slot>
            <input ref="file" type="file" name="file" class="uk-hidden" @change="submit">
        </form>
        <a @click="upload" class="uk-button uk-button-success">{{ group ? 'Дополнить группу из файла' : 'Импортировать пользователей' }}</a>
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
