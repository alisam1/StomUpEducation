<template>
    <div id="trans_settings" class="trans_settings">
        <div class="trans_settings-container">
            <div class="trans_title"><p>Настройки трансляции</p></div>

            <div class="trans_checkboxes">
                <div class="trans_left"><Checkbox /><p>Звук</p></div>
                <div class="trans_right"><Checkbox /><p>Камера</p></div>
            </div>

            <p class="trans_titleH2">Качество</p>
            <div class="trans_quality">
                <div @click="onChangeQuality" id="240q" class="trans_item">240</div>
                <div @click="onChangeQuality" id="320q" class="trans_item">320</div>
                <div @click="onChangeQuality" id="480q" class="trans_item">480</div>
                <div @click="onChangeQuality" id="720q" class="trans_item">720</div>
                <div @click="onChangeQuality" id="1080q" class="trans_item">1080</div>
            </div>

            <div class="trans_help">
                <Tooltip textMessage="Текст для справки"/>
                <p>Проблема с трансляцией? Мы поможем</p>
            </div>

        </div>
    </div>
</template>

<script>
    import Checkbox from '@/components/Checkbox_custom1.vue';
    import Tooltip from '@/components/Tooltip_question.vue';
    
    export default {
        name: 'Broadcast',
        components: {
            Checkbox, Tooltip
        },
        methods: {
            onChangeQuality(e) {
                e.currentTarget.classList.toggle("trans_active");
                document.getElementById(this.$store.getters.getCurrentQuality).classList.toggle("trans_active");
                this.$store.dispatch ('SET_QUALITY', e.currentTarget.id);
            },
        },
        mounted() {
            document.getElementById(this.$store.getters.getCurrentQuality).classList.toggle("trans_active");
        },
    }
</script>

<style scoped="true">
    .trans_screen .trans_settings {
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(67, 68, 68, 0.78);
        
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .trans_screen .trans_settings-active {
        visibility: visible;
    }
    
    .trans_screen .trans_settings .trans_settings-container {
        height: auto;
        width: 79.31%;
        background-color: rgba(67, 68, 68, 0.95);
        opacity: 1;
        border-radius: 10px;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_title {
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        line-height: 22px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 12px;
        margin-bottom: 10px;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_checkboxes {
        width: 90.2%;
        margin-left: 9.8%;
        height: 21px;
        display: flex;
        flex-direction: row;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_checkboxes p {
        font-size: 14px;
        line-height: 22px;
        color: #FFFFFF;
        font-weight: normal;
        margin-left: 13px;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_checkboxes .trans_left, .trans_screen .trans_settings .trans_settings-container .trans_checkboxes .trans_right {
        width: 50%;
        display: flex;
        flex-direction: row;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_titleH2 {
        color: #FFFFFF;
        font-size: 12px;
        line-height: 22px;
        margin-left: 9.8%;
        margin-top: 10px;
        margin-bottom: 3px;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_quality {
        width: 93.5%;
        margin-left: 6.5%;
        display: flex;
        flex-direction: row;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_quality .trans_item {
        height: 24px;
        width: 45px;
        
        display: flex;
        justify-content: center;
        align-items: center;
        
        color: #FFFFFF;
        font-size: 14px;
        font-weight: normal;
        
        border-radius: 5px;
        background-color: transparent;
        margin-left: 7px;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_quality .trans_item:hover {
        cursor: pointer;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_quality .trans_item:first-child {
        margin-left: 0;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_quality .trans_active {
        background-color: #292929;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_help {
        width: 90.2%;
        height: 18px;
        margin-left: 9.8%;
        margin-top: 10px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        flex-direction: row;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_help p {
        font-size: 10px;
        font-weight: normal;
        color: #FFFFFF;
        margin-left: 8px;
        text-decoration: underline;
    }
    
    .trans_screen .trans_settings .trans_settings-container .trans_help p:hover {
        cursor: pointer;
    }
</style>
