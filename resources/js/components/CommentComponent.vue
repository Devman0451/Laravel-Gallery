<template>
    <div>
        <button 
            class="btn btn-dark reply" 
            @click="toggleTextBox"
            >Reply
        </button>

        <AddComment v-if="showReplyBox"/>
    </div>
</template>

<script>
    import AddComment from './AddCommentComponent';

    export default {
        props: {
        },

        components: {
            AddComment
        },

        data() {
            return {
                showReplyBox: false
            }
        },

        methods: {
            toggleTextBox() {
                this.showReplyBox = !this.showReplyBox;
            }
        },

        computed: {

        },
    }
</script>

<style scoped>
    .reply {
        margin-bottom: 10px;
    }
</style>
