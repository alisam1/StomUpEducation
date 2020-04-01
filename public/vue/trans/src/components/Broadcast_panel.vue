<template>
    <div class="trans_panel">
        <div class="trans_left">
            <p>Минимально инвазивные методики лечения фронтальной группы зубов</p>
        </div>

        <div class="trans_right">
            <img src="@/assets/icon_fullscreen2.svg" alt="icon" />
            <img @click="toggleSettings" src="@/assets/icon_settings.svg" alt="icon" />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Broadcast_panel',
        methods: {
            toggleSettings(e) {
                document.getElementById("trans_settings").classList.toggle("trans_settings-active");
            },
        },
    }
</script>

<style scoped="true">
    .trans_panel {
        width: 100%;
        height: 10.73%;
        background-color: #444444;
        display: flex;
        flex-direction: row;
    }
    
    .trans_panel .trans_left {
        height: 100%;
        width: 70%;
    }
    
    .trans_panel .trans_left p {
        line-height: 26px;
        font-size: 10px;
        color: #D1D1D1;
        margin-left: 21px;
        
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .trans_panel .trans_right {
        height: 100%;
        width: 30%;
        display: flex;
        justify-content: flex-end; 
        align-items: center;
    }
    
    .trans_panel .trans_right img {
        margin-right: 12px;
    }
    
    .trans_panel .trans_right img:hover {
        cursor: pointer;
    }
</style>
