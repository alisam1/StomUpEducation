<template>
    <div class="chat_navigation">
        <div class="chat_container">
            <div @click="onChangePanel" id="all" class="chat_navigationButtons">Все</div>
            <div @click="onChangePanel" id="invited" class="chat_navigationButtons">Приглашённые</div>
            <div @click="onChangePanel" id="involved" class="chat_navigationButtons">Участвующие</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Chat_membersBlock',
        methods: {
            //Функция переключения
            onChangePanel(e) {
                //Делаем кнопку активной
                e.currentTarget.classList.toggle("chat_active");
                //Убираем активный класс с предыдущей активной кнопки
                document.getElementById(this.$store.getters.getCurrentPanelMembers).classList.toggle("chat_active");
                //Записываем id текущей активной кнопки в хранилище
                this.$store.dispatch ('SET_CURRENT_PANEL_MEMBERS', e.currentTarget.id);
            }
        },
        //При прогрузке элементов
        mounted() {
            //Установка активной кнопки, указанной в хранилище
            document.getElementById(this.$store.getters.getCurrentPanelMembers).classList.toggle("chat_active");
        },
    }
</script>

<style scoped="true">
    .chat_navigation {
        height: 39px;
        height: 6.47%;
        width: 100%;
        border-bottom: 1px solid #E5E5E5;
        display: flex;
        align-items: center;
    }
    
    .chat_navigation .chat_container {
        height: 64.1%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
    }
    
    .chat_navigation .chat_container .chat_navigationButtons {
        padding-left: 4.56%;
        padding-right: 4.56%;
        margin-left: 4.56%;
        border-radius: 5px;
        height: 23px;
        border: solid 1px #FFFFFF;
        
        display: flex;
        justify-content: center;
        align-items: center;
        
        font-size: 10px;
        color: #4F4F4F;
        text-transform: uppercase;
    }
    
    .chat_navigation .chat_container .chat_navigationButtons:first-child {
        margin-left: 0;
    }
    
    .chat_navigation .chat_container .chat_navigationButtons:hover {
        cursor: pointer;
    }
    
    .chat_navigation .chat_container .chat_active {
        border: solid 1px #2C78F6;
    }
</style>
