<template>
    <div class="container my-5">
        <div class="row">
            <div class="col-11 m-auto message-container">

                <div class="message-title-header d-flex flex-row">
                    <a :href="`/profile/${otherUser.profile.id}`"><img :src="otherUser.profile.profile_img" alt="profile" class="rounded-circle"></a>
                    <div class="message-title-header--text mt-1 ml-3">
                        <h4 class="text-left">Message with <a :href="`/profile/${otherUser.profile.id}`" class="text-light" v-text="otherUser.username"></a></h4>
                        <h6>{{ messages.length }} Messages</h6>
                    </div>
                </div>

                <div class="message-window" v-chat-scroll>

                    <div :class="isUserMessage(message) ? 'message-user-message' : 'message-user-message foreign-message'" 
                        v-for="message in messages" 
                        :key="message.id" >
                        <div :class="isUserMessage(message) ? 'message-title-header--text mt-2 d-flex flex-row' : 'message-title-header--text mt-1 d-flex flex-row foreign-user'"
                            v-if="isUserMessage(message)">
                            <img :src="message.owner.profile.profile_img" alt="profile" class="rounded-circle message-img">
                            <p class="text-left message-user-text" v-text="message.message"></p>
                        </div>

                        <div :class="isUserMessage(message) ? 'message-title-header--text mt-2 d-flex flex-row' : 'message-title-header--text mt-1 d-flex flex-row foreign-user'"
                            v-else>
                            <p class="text-left message-user-text foreign-text" v-text="message.message"></p>
                            <img :src="message.owner.profile.profile_img" alt="profile" class="rounded-circle message-img">
                        </div>
                        <p :class="isUserMessage(message) ? 'text-left message-user-date' : 'text-right message-user-date'"><span class="message-date">{{ message.created_at }}</span></p>
                    </div>

                </div>

                <div class="message-form-container">
                    <div class="message-form d-flex flex-row">
                        <textarea class="message-textarea" 
                                  name="message" 
                                  cols="30" 
                                  rows="10" 
                                  placeholder="Type your message..." 
                                  v-model="text"
                                  @keydown="userTypingEvent"></textarea>
                        <button type="submit" class="text-white message-btn-send" @click="postMessages" :disabled="disableSubmit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                     <span v-if="activeUser" class="text-muted message-is-typing">{{ activeUser.username }} is typing...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AddComment from './AddCommentComponent';

    export default {
        props: {
            user: Object,
            otherUser: Object,
            conversation: Object
        },

        data() {
            return {
                messages: [],
                text: '',
                activeUser: null,
                activeUserTimeout: null,
                error: false
            }
        },

        mounted() {
            this.getMessages();
            this.listen();
        },

        methods: {
            isUserMessage(message) {
                return message.sender_id == this.user.id;
            },
            getMessages() {
                axios.get(`/messages/${this.conversation.id}/messages`)
                    .then(res => this.messages = res.data)
                    .catch(err => this.error = err)
            }, 
            postMessages() {
                axios.post(`/messages/${this.conversation.id}/message`, {
                    'message': this.text
                })
                    .then(res => {
                        this.messages.push(res.data);
                        this.text = '';
                    })
                    .catch(err => this.error = err)
            },
            listen() {
                Echo.join(`chat.${this.conversation.id}`)
                    .listen('NewMessage', message => {
                        this.messages.push(message);
                    })
                    .listenForWhisper('typing', user => {
                        this.activeUser = user;

                        if (this.activeUserTimeout) {
                            clearTimeout(this.activeUserTimeout);
                        }

                        this.activeUserTimeout = setTimeout(() => {
                            this.activeUser = null;
                        }, 3000);
                    })
            },
            userTypingEvent() {
                Echo.join(`chat.${this.conversation.id}`)
                    .whisper('typing', this.user)
            }
        },

        computed: {
            disableSubmit() {
                return this.text.length < 1;
            }
        },
    }
</script>
