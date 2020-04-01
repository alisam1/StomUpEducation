<template>
    <div id="chat">
        
        <Navigation />
        
        <MessagesBlock v-if="activePanel === 'chatPanel'"/>
        <MembersBlock v-else-if="activePanel === 'membersPanel'"/>
         
    </div>
</template>

<script>
    import MessagesBlock from './components_chat/Messages.vue';
    import MembersBlock from './components_chat/Members.vue';
    import Navigation from './components_chat/Navigation.vue';
    
    export default {
        name: 'Chat',
        components: {
            Navigation, MessagesBlock, MembersBlock,
        },
        computed: {
            activePanel() {
                return this.$store.getters.getCurrentPanel;
            }
        },
    }
</script>

<style scoped="true">
    #chat {
        width: 100%;
        height: 73.2%;
        display: flex;
        flex-direction: column;
    }
</style>
