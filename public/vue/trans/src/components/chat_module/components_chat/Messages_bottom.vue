<template>
    <div class="chat_bottom">
        <textarea v-on:keyup.enter="pushMessage" v-model="message" type="text" placeholder="Ваше сообщение" />
        <img @click="pushMessage" src="../assets/icon_send.svg" />
    </div>
</template>

<script>
    export default {
        name: 'Chat_messagesBlock_bottom',
        data() {
            return {
                firstName: "Максим",
                lastName: "Максимов",
                message: "",
                admin: "false",
                id: "0",
            }
        },
        methods: {
            pushMessage(e) {
                if (this.$data.message.trim() != "") {
                    //Убираем пробелы с начала и конца перед отправкой
                    this.$data.message = this.$data.message.trim();
                    //Копируем объект с сообщением и отправляем
                    this.$store.dispatch ('PUSH_MESSAGE', JSON.parse(JSON.stringify(this.$data)));
                    //Очищаем поле ввода
                    this.$data.message = "";
                    
                    //this.$store.dispatch ('SET_LAST_SENDER', this.$data.id );
                    
                    
                    //document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
                }
            },
        }
    }
</script>

<style scoped="true">
    .chat_bottom {
        /*width: 94.4%;*/
        width: 100%;
        padding-left: 5.6%;
        height: 8.14%;
        background-color: #FFFFFF;
        border-top: 1px solid #E5E5E5;
        display: flex;
        flex-direction: row;
    }
    
    .chat_bottom textarea {
        width: 85%;
        margin-right: 5%;
        resize: none;
        border: 0;
        outline: 0;
        background: transparent;
        
        color: #333333;
        font-size: 16px;
        line-height: 20px;
    }
    
    .chat_bottom textarea::placeholder {
        color: #9E9E9E;
        font-size: 12px;
    }
    
    .chat_bottom img:hover {
        cursor: pointer;
    }
</style>
