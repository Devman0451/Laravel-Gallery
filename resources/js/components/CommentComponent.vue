<template>
    <div class="comment-single pt-1">
        <p><a :href="commentLink" class="text-light">{{ commentOwner }}</a><span> on </span> {{ commentDate }}</p>
        <p>{{ commentText }}</p>
        <button 
            class="btn btn-dark reply-btn" 
            @click="toggleTextBox"
            v-if="owner"
            >Reply
        </button>

        <AddComment :buttontext="'Reply'" 
                    :name="'reply'" 
                    v-if="showReplyBox"/>
     
    </div>
</template>

<script>
    import AddComment from './AddCommentComponent';

    export default {
        props: {
            comment: Object,
            owner: Boolean
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
            commentText() {
                return this.comment ? this.comment.comment : "";
            },
            commentOwner() {
                return this.comment ? this.comment.owner.username : "";
            },
            commentDate() {
                return this.comment ? this.comment.created_at : "";
            },
            commentLink() {
                return this.comment ? `/profile/${this.comment.owner.profile.id}` : '';
            }
        },
    }
</script>

<style scoped>
    .reply-btn {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>
