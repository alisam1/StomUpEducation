<template>
    <div class="trans_content">
        <Slide />
        <div class="trans_aside">
            <Broadcast />
            <Chat />
        </div>
    </div>
</template>

<script>
    import Slide from '@/components/Slide.vue';
    import Chat from '@/components/chat_module/Chat.vue';
    import Broadcast from '@/components/Broadcast.vue';
    
    export default {
        name: 'App',
        components: {
            Slide, Chat, Broadcast
        }
    }
</script>

<style>
    .trans_content {
        /*height: 92.55%;*/
        height: 100%;
        width: 100%;
        min-width: 1000px;
        display: flex;
        flex-direction: row;
        font-family: 'Montserrat', sans-serif;
    }
    
    .trans_content .trans_slide {
        height: 100%;
        /*width: 75.7%;*/
        width: calc(100% - 330px);
        display: flex;
        flex-direction: column;
    }
    
    .trans_content .trans_aside {
        height: 100%;
        /*width: 24.3%;*/
        width: 330px;
        display: flex;
        flex-direction: column;
    }
</style>
