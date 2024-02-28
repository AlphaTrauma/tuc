<template>
    <div>
        <form :action="`/contractors/${id}/upload`" ref="form" method="post" enctype="multipart/form-data">
            <slot></slot>
            <a @click="upload" class="uk-button uk-button-success">Импортировать пользователей</a>
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
