<template>
    <div class="chat_membersBlock">
        <Navigation />
        
        <MembersList />
        
        <div class="chat_bottom">
            <div class="chat_button">
                <p>+ Пригласить еще</p>
            </div>
        </div>
    </div>
</template>

<script>
    import Navigation from './Members_navigation.vue';
    import MembersList from './Members_memberList.vue';
    
    export default {
        name: 'Chat_membersBlock',
        components: {
            Navigation, MembersList,
        },
    }
</script>

<style scoped="true">
    .chat_membersBlock {
        width: 100%;
        height: 94.65%;
        background: #FFFFFF;
    }
    
    .chat_membersBlock .chat_bottom {
        width: 100%;
        height: 8%;
    }
    
    .chat_membersBlock .chat_bottom .chat_button {
        width: 147px;
        height: 38px;
        margin-left: 30px;
        border: 1px solid #2C78F6;
        border-radius: 5px;
        
        display: flex;
        justify-content: center;
        align-items: center;
        
        color: #2C78F6;
        font-weight: bold;
        font-size: 10px;
        text-transform: uppercase;
    }
    
    .chat_membersBlock .chat_bottom .chat_button:hover {
        cursor: pointer;
        background-color: #2C78F6;
        color: #FFFFFF;
    }
</style>
