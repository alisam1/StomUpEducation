<template>
    <div class="trans_slide">
        
        
        <div class="trans_main" >
            <div class="trans_container">
                
                <Header />
                
                <p class="trans_description">
                - Лечение дисколорита фронтальной группы зубов <br/>
                - Методики лечения полного вывиха фронтального постоянного зуба в детской стоматологии <br/>
                - Профилактика и применение реминерализационной терапии для лечения деминерализации эмали <br/>
                </p>
                
                <div class="trans_buttons">
                    <div class="trans_subscribe">
                        <p>ПОДПИСАТЬСЯ</p>
                    </div>
                    <div class="trans_watch">
                        <p>СМОТРЕТЬ</p>
                    </div>
                </div>
                
                <div class="trans_line"></div>
                
                <div class="trans_icon">
                    <img src="@/assets/icon_center.svg" alt="icon" />
                    <div class="trans_title">
                        <p class="trans_name">Питер Экспо</p>
                        <p class="trans_type">ОРГАНИЗАТОР КУРСА</p>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div class="trans_footer">
            <div class="trans_left">
                <img src="@/assets/icon_videoCamera.svg" alt="icon" />
                <img src="@/assets/icon_presentation.svg" alt="icon" />
                <img src="@/assets/icon_dialogue.svg" alt="icon" />
            </div>
            <div class="trans_right">
                <img src="@/assets/icon_fullscreen1.svg" alt="icon" />
            </div>
        </div>
    </div>
</template>

<script>
    import Header from '@/components/Slide_header.vue';
    
    export default {
        name: 'Trans_Slide',
        components: {
            Header
        }
    }
</script>

<style>
    .trans_slide .trans_main {
        width: 100%;
        height: 94.25%;
        display: flex;
        background: #5da1a6;
        font-family: 'Montserrat', sans-serif;
    }
    .trans_slide .trans_main .trans_container {
        margin-left: 7.3%;
        /*width: 59%;*/
        width: 80%;
        
        margin-top: 136px;
        height: auto;
        
        background: #5da1a6;
    }
    
    .trans_slide .trans_main .trans_container .trans_description {
        margin-top: 20px;
        line-height: 20px;
        letter-spacing: 0;
        font-size: 14px;
        color: #FFFFFF;
        font-weight: normal;
    }
    
    .trans_slide .trans_main .trans_container .trans_buttons {
        margin-top: 12px;
        margin-bottom: 30px;
        width: 100%;
        height: 40px;
        
        display: flex;
        flex-direction: row;
    }
    
    .trans_slide .trans_main .trans_container .trans_buttons:hover {
        cursor: pointer;
    }
    
    .trans_slide .trans_main .trans_container .trans_buttons .trans_subscribe, .trans_slide .trans_main .trans_container .trans_buttons .trans_watch {
        width: 148px;
        height: 38px;
        
        box-sizing: border-box;
        border-radius: 5px;
        
        display: flex;
        justify-content: center;
        align-items: center;
        
        font-size: 12px;
        line-height: 38px;
        font-weight: bold;
        color: #FFFFFF;
    }
    
    .trans_slide .trans_main .trans_container .trans_buttons .trans_subscribe {
        border: 1px solid #FFFFFF;
        background-color: transparent;
    }
    
    .trans_slide .trans_main .trans_container .trans_buttons .trans_subscribe:hover {
        background-color: #2C78F6;
        color: #FFFFFF;
        border-color: #2C78F6;
    }
    
    .trans_slide .trans_main .trans_container .trans_buttons .trans_watch {
        border: 1px solid #2C78F6;
        margin-left: 16px;
        flex-direction: row;
        background-color: #2C78F6;
    }
    
    .trans_slide .trans_main .trans_container .trans_buttons .trans_watch:hover {
        background-color: #1C63D8;
    }
    
    .trans_slide .trans_main .trans_container .trans_line {
        height: 1px;
        width: 80%;
        background-color: #FFFFFF;
        opacity: 0.24;
    }
    
    .trans_slide .trans_main .trans_container .trans_icon {
        margin-top: 29px;
        height: 47px;
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
    }
    
    .trans_slide .trans_main .trans_container .trans_icon .trans_title {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-left: 15px;
    }
    
    .trans_slide .trans_main .trans_container .trans_icon .trans_title .trans_name {
        line-height: 22px;
        font-size: 18px;
        font-weight: 600;
        color: #FFFFFF;
    }
    
    .trans_slide .trans_main .trans_container .trans_icon .trans_title .trans_type {
        line-height: 16px;
        font-size: 12px;
        color: #FFFFFF;
        font-weight: lighter;
    }
    
    .trans_slide .trans_footer {
        width: 100%;
        height: 5.75%;
        background-color: #444444;
        display: flex;
        flex-direction: row;
    }
    
    .trans_slide .trans_footer .trans_left, .trans_slide .trans_footer .trans_right {
        display: flex;
        flex-direction: row;
        align-items: center;
        width: 50%;
        height: 100%;
    }
    
    .trans_slide .trans_footer .trans_right {
        justify-content: flex-end;
    }
    
    .trans_slide .trans_footer .trans_left img {
        margin-left: 26px;
    }
    
    .trans_slide .trans_footer .trans_left img:first-child {
        margin-left: 14.6%;
    }
    
    .trans_slide .trans_footer .trans_right img {
        margin-right: 27px;
    }
</style>
