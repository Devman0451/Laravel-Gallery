<template>
    <div class="reply-textbox">
        <div class="comment-form reply-textbox">
            <textarea name="comment" cols="30" rows="10" class="comment" v-model="commentField"></textarea>
            <input type="submit" name="submit" value="Submit" class="btn-subscribe" :disabled="commentField.length == 0" @click.prevent="postComment">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: Object
        },

        data() {
            return {
                commentField: '',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        methods: {
            postComment() {
                
            }
        }
    }
</script>

<style scoped>
    .reply-textbox {
        width: 100%;
    }

</style>


