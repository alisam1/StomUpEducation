<template>
    <div class="chat_messagesBlock">
        
        
        
        
        
        
        <div id="messages" class="chat_messages">
            <div>
                <button @click="pushMessage(person1)">Person1</button>
                <button @click="pushMessage(person2)">Person2</button>
                <button @click="pushMessage(person3)">Person3</button>
            </div>
            
            <div 
                 v-for="message in messages"
                 :class="[message.id == '0' ? 'chat_youMessage' : 'chat_otherMessage']">
                
                <MessageAuthor :message="message"/>
                <p class="chat_message">{{ message.message }}</p>
                
            </div>
            
        </div>
        
        
        
        
        
        
        
        <Bottom />
    </div>
</template>

<script>
    import MessageAuthor from './Messages_messageAuthor.vue';
    import Bottom from './Messages_bottom.vue';
    
    export default {
        name: 'Chat_messagesBlock',
        components: {
            Bottom, MessageAuthor
        },
        data() {
            return {
                person1: {
                    firstName: "Олег",
                    lastName: "Олегов",
                    message: "Я хочу спать и кушац, и спать и кушац",
                    admin: "false",
                    id: "3",
                },
                person2: {
                    firstName: "Алексей",
                    lastName: "Алексеев",
                    message: "ыфвфывфывфывфывфыцвцфвцфвфвфцвцфвцфвф",
                    admin: "true",
                    id: "2",
                },
                person3: {
                    firstName: "Александр",
                    lastName: "Иванов",
                    message: "Я хочу спать",
                    admin: "false",
                    id: "1",
                }
            }
        },
        methods: {
            pushMessage(person) {
                this.$store.dispatch ('PUSH_MESSAGE', person);
                //document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            },
        },
        computed: {
            messages() {return this.$store.getters.getMessages;},
        },
    }
</script>

<style scoped="true">
    .chat_messagesBlock {
        width: 100%;
        height: 94.65%;
        display: flex;
        flex-direction: column;
    }
    
    .chat_messagesBlock .chat_messages {
        width: 100%;
        padding-left: 4.96%;
        padding-right: 4.96%;
        height: 91.86%;
        background: #FFFFFF;
        
        display: flex;
        flex-flow: column nowrap;
        overflow-y: auto;
    }
    
    .chat_messagesBlock .chat_otherMessage, .chat_messagesBlock .chat_youMessage {
        max-width: 70%;
    }
    
    .chat_messagesBlock .chat_otherMessage {
        align-self: flex-start;
    }
    
    .chat_messagesBlock .chat_youMessage {
        align-self: flex-end;
    }
    
    .chat_messagesBlock .chat_otherMessage .chat_message, .chat_messagesBlock .chat_youMessage .chat_message {
        padding: 6px 14px 5px 7px;
        font-size: 12px;
        line-height: 16px;
        border-radius: 5px;
        word-wrap: break-word;
        margin-bottom: 5px;
    }
    
    .chat_messagesBlock .chat_otherMessage .chat_message {
        background: #FFFFFF;
        border: 1px solid #E5E5E5;
        color: #333333;
    }
    
    .chat_messagesBlock .chat_youMessage .chat_message {
        background: #2C78F6;
        color: white;
    }
    
    .chat_messagesBlock .chat_youMessage .chat_message {
        display: flex;
        justify-content: flex-end;
    }
</style>