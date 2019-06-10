<template>
    <div class="reply-textbox">
        <form :action="endpoint" method="post" class="comment-form" @submit.prevent="submitComment">
            <input type="hidden" name="_token" :value="csrf">
            <textarea :name="name" cols="30" rows="10" class="comment" v-model="comment"></textarea>
            <input type="submit" 
                   :name="name" 
                   :value="buttontext" 
                   class="btn-subscribe"
                   :disabled="comment.length == 0"
                   >
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            buttontext: String,
            name: String,
            endpoint: String
        },

        data() {
            return {
                comment: '',
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        methods: {
            submitComment(e) {
                axios.post(this.endpoint, {
                    'comment' : this.comment
                })
                .then(res => location.reload())
                .catch();
            }
        }
    }
</script>

<style scoped>
    .reply-textbox {
        width: 100%;
    }

</style>


