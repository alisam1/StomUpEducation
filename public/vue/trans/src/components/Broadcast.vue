<template>
    <div id="trans_broadcast">
        
        <div class="trans_screen">
            <div class="trans_main">
                <img v-if="!isCameraActive" src="@/assets/icon_screenCameraDisabled.svg" alt="icon"/>
            </div>
            
            <img class="trans_play_button" src="@/assets/play_button.svg" alt="play" />
            
            <div @click="toggleMicrophone" class="trans_microphone">
                <img v-if="isMicrophoneActive" src="@/assets/microphone_button.svg" alt="micro" />
                <img v-else src="@/assets/microphone_button_disabled.svg" alt="micro" />
            </div>
            
            <div @click="toggleCamera" class="trans_camera">
                <img v-if="isCameraActive" src="@/assets/videocam_button.svg" alt="camera" />
                <img v-else src="@/assets/videocam_button_disabled.svg" alt="camera" />
            </div>
            
            <Settings />
            
        </div>
        
        <Panel />
        
    </div>
</template>

<script>
    import Settings from '@/components/Broadcast_settings.vue';
    import Panel from '@/components/Broadcast_panel.vue';
    
    export default {
        name: 'Broadcast',
        components: {
            Settings, Panel
        },
        data() {
            return {
                isCameraActive: true,
                isMicrophoneActive: true,
            }
        },
        methods: {
            toggleCamera(e) {
                e.currentTarget.classList.toggle("trans_disabled");
                this.$data.isCameraActive = !this.$data.isCameraActive;
            },
            toggleMicrophone(e) {
                e.currentTarget.classList.toggle("trans_disabled");
                this.$data.isMicrophoneActive = !this.$data.isMicrophoneActive;
            },
        },
    }
</script>

<style scoped="true">
    #trans_broadcast {
        width: 100%;
        height: 26.8%;
    }
    
    .trans_screen {
        width: 100%;
        height: 89.27%;
        background-color: grey;
        position: relative;
    }
    
    .trans_screen .trans_play_button {
        position: absolute;
        left: 46.767%;
        /*top: 113px;*/
        top: 40.5%;
    }
    
    .trans_screen .trans_main {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .trans_screen .trans_camera, .trans_screen .trans_microphone {
        position: absolute;
        width: 38px;
        height: 38px;
        background-color: #3EC45B;
        border-radius: 100px;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.2);
        
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .trans_screen .trans_disabled, .trans_screen .trans_disabled {
        background-color: #E73638;
    }
    
    .trans_screen .trans_camera:hover, .trans_screen .trans_microphone:hover {
        cursor: pointer;
    }
    
    .trans_screen .trans_microphone {
        bottom: 18px;
        right: 19.39%;
    }
    
    .trans_screen .trans_camera {
        bottom: 18px;
        right: 5.6%;
    }
</style>
