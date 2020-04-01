<template>
    <div class="chat_navigationBlock">
        <div @click="onChangePanel" id="chatPanel" class="chat_navigationButton">Чат</div>
        <div @click="onChangePanel" id="membersPanel" class="chat_navigationButton">Участники</div>
    </div>
</template>

<script>
    export default {
        name: 'Chat',
        computed: {
            isPanel() {
                return this.$store.getters.getCurrentPanel;
            }
        },
        methods: {
            //Функция переключения
            onChangePanel(e) {
                //Делаем кнопку активной
                e.currentTarget.classList.toggle("chat_activeButton");
                //Убираем активный класс с предыдущей активной кнопки
                document.getElementById(this.$store.getters.getCurrentPanel).classList.toggle("chat_activeButton");
                //Записываем id текущей активной кнопки в хранилище
                this.$store.dispatch ('SET_CURRENT_PANEL', e.currentTarget.id);
            }
        },
        //При прогрузке элементов
        mounted() {
            //Установка активной кнопки, указанной в хранилище
            document.getElementById(this.$store.getters.getCurrentPanel).classList.toggle("chat_activeButton");
        },
    }
</script>

<style scoped="true">
    .chat_navigationBlock {
        width: 100%;
        height: 5.35%;
        display: flex;
        flex-direction: row;
    }
    
    .chat_navigationBlock .chat_navigationButton {
        width: 50%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        text-transform: uppercase;
        background-color: #ECECEC;
        
        color: #717171;
        font-size: 12px;
        font-weight: bold;
    }
    
    .chat_navigationBlock .chat_navigationButton:hover {
        cursor: pointer;
    }
    
    .chat_navigationBlock .chat_activeButton {
        background-color: #FFFFFF;
    }
</style>
