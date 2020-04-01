<template>
            <p v-if="isRender" class="chat_name">{{ message.firstName }} {{ message.lastName.slice(0,1) }}.
                <span v-if="message.admin == 'true'">&nbsp;(Админ)</span>
                <span v-if="message.id == '0'">&nbsp;(Вы)</span>
            </p>
</template>

<script>
    export default {
        name: 'Chat_messagesBlock_message',
        props: {
            message: Object,
        },
        data() {
            return {
                isRender: true,
            }
        },
        mounted() {
            if (this.$store.getters.getLastSender == this.$props.message.id) this.$data.isRender = false;
            this.$store.dispatch ('SET_LAST_SENDER', this.$props.message.id );
        }
    }
</script>

<style scoped="true">
    .chat_name {
        font-size: 12px;
        line-height: 20px;
        font-weight: 600;
        margin-top: 10px;
    }
    
    .chat_youMessage .chat_name {
        display: flex;
        justify-content: flex-end;
    }
    
    .chat_name span {
        color: #A3A3A3;
    }
</style>
