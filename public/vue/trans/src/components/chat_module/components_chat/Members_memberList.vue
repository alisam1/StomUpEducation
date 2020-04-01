<template>
        <div class="chat_membersList">
            <!-- Каждый рендер отличается только входным списком-->
            
            <!-- Отрисовка всех участников-->
            <div v-if="isPanel == 'all'" v-for="person in people" class="chat_person">
                <div class="chat_left">
                    <div class="chat_icon">
                        <img :src="person.imgUrl" alt="photo" />
                    </div>
                    <p>{{ person.firstName }} {{ person.lastName.slice(0,1) }}.</p>
                </div>
                <div class="chat_right">
                    <p v-if="person.awaiting == 'true'">Ожидает подтверждения</p>
                </div>
            </div>
            
            <!-- Отрисовка ожидаемых участников-->
            <div v-if="isPanel == 'invited'" v-for="person in peopleInvited" class="chat_person">
                <div class="chat_left">
                    <div class="chat_icon">
                        <img :src="person.imgUrl" alt="photo" />
                    </div>
                    <p>{{ person.firstName }} {{ person.lastName.slice(0,1) }}.</p>
                </div>
                <div class="chat_right">
                    <p v-if="person.awaiting == 'true'">Ожидает подтверждения</p>
                </div>
            </div>
            
            <!-- Отрисовка участвующих участников-->
            <div v-if="isPanel == 'involved'" v-for="person in peopleInvolved" class="chat_person">
                <div class="chat_left">
                    <div class="chat_icon">
                        <img :src="person.imgUrl" alt="photo" />
                    </div>
                    <p>{{ person.firstName }} {{ person.lastName.slice(0,1) }}.</p>
                </div>
                <div class="chat_right">
                    <p v-if="person.awaiting == 'true'">Ожидает подтверждения</p>
                </div>
            </div>
            
        </div>
</template>

<script>
    export default {
        name: 'Chat_membersBlock',
        computed: {
            //Получение списков
            people() {return this.$store.getters.getPeople;},
            peopleInvited() {return this.$store.getters.getPeopleInvited;},
            peopleInvolved() {return this.$store.getters.getPeopleInvolved;},
            
            //Получение текущей вкладки
            isPanel() {return this.$store.getters.getCurrentPanelMembers;},
        },
    }
</script>

<style scoped="true">
    .chat_membersList {
        width: 93.53%;
        margin-left: 6.47%;
        /*height: 83%;*/
        height: 85.3%;
        display: flex;
        flex-direction: column;
        
        overflow-y: auto;
    }
    
    .chat_membersList .chat_person {
        height: 33px;
        width: 100%;
        margin-bottom: 13px;
        display: flex;
        flex-direction: row;
    }
    
    .chat_membersList .chat_left {
        width: 60%;
        height: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
    }
    
    .chat_membersList .chat_left p {
        color: #4F4F4F;
        font-size: 10px;
        text-transform: uppercase;
        margin-left: 12px;
    }
    
   .chat_membersList .chat_left .chat_icon {
        height: 33px;
        width: 33px;
        background: yellow;
        border-radius: 100px;
    }
    
    .chat_membersList .chat_left .chat_icon img {
        border-radius: 100px;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .chat_membersList .chat_right {
        width: 33%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        
        color: #ACACAC;
        font-size: 10px;
    }
    
    .chat_membersList .chat_person:first-child {
        margin-top: 17px;
    }
</style>
