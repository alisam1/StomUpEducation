<template>
    <div class="trans_info_webinar-header-container-left">


        <div class="trans_info_webinar-header-container-left-tags">
            <div class="trans_info_webinar-header-container-left-tags-item">
                <div class="trans_circle_icon"></div>
                <p class="trans_theme">Пародонтология</p>
            </div>
            <div class="trans_info_webinar-header-container-left-tags-item">
                <p class="trans_type">Вебинар</p>
            </div>
        </div>


        <div class="trans_info_webinar-header-container-left-name">
            <p>Минимально инвазивные методики лечения фронтальной группы зубов</p>
        </div>


        <div class="trans_info_webinar-header-container-left-info">
            <div class="trans_info_webinar-header-container-left-info-item">
                <img src="@/assets/icon_calendar.svg" alt="icon" />
                <p>16.01.2020</p>
            </div>
            <div class="trans_info_webinar-header-container-left-info-item">
                <img src="@/assets/icon_clock.svg" alt="icon" />
                <p>16:00 – 18:00</p>
            </div>
            <div class="trans_info_webinar-header-container-left-info-item">
                <p>+3 GMT (Москва)</p>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        name: 'Slide_header',
    }
</script>

<style>  
    .trans_info_webinar-header-container-left {
        width: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .trans_info_webinar-header-container-left-tags {
        width: 100%;
        height: 26px;
        
        display: flex;
        flex-direction: row;
    }
    
    .trans_info_webinar-header-container-left-tags div {
        margin-left: 11px;
    }
    
    .trans_info_webinar-header-container-left-tags div:first-child {
        margin-left: 0px;
    }
    
    .trans_info_webinar-header-container-left-tags-item {
        height: 100%;
        padding-left: 10px;
        padding-right: 10px;
        flex-basis: content;
        
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        
        border-radius: 33px;
        background: #FFFFFF;
    }
    
    .trans_info_webinar-header-container-left-tags-item .trans_circle_icon {
        width: 8px;
        height: 8px;
        background-color: #2BC3A8;
        margin-right: 4px;
        border-radius: 73px;
    }
    
    .trans_info_webinar-header-container-left-tags-item .trans_theme {
        font-size: 12px;
        font-weight: 600;
        color: #30353E;
    }
    
    .trans_info_webinar-header-container-left-tags-item .trans_type {
        font-size: 12px;
        font-weight: 600;
        color: #2C78F6;
    }
    
    .trans_info_webinar-header-container-left-name {
        width: 100%;
        margin-top: 22px;
        height: auto;
    }
    
    .trans_info_webinar-header-container-left-name p {
        font-size: 34px;
        color: #FFFFFF;
        font-weight: normal;
    }
    
    .trans_info_webinar-header-container-left-info {
        width: 100%;
        margin-top: 29px;
        height: 22px;
        
        display: flex;
        flex-direction: row;
    }
    
    .trans_info_webinar-header-container-left-info-item {
        margin-left: 4.18%;
        height: 100%;
        
        display: flex;
        flex-direction: row;
        align-items: center;
    }
    
    .trans_info_webinar-header-container-left-info .trans_info_webinar-header-container-left-info-item:first-child {
        width: 102px;
        margin-left: 0px;
    }
    
    .trans_info_webinar-header-container-left-info .trans_info_webinar-header-container-left-info-item:nth-child(2) {
        width: 120px;
    }
    
    .trans_info_webinar-header-container-left-info .trans_info_webinar-header-container-left-info-item:last-child {
        max-width: 216px;
    }
    
    .trans_info_webinar-header-container-left-info-item p {
        font-size: 14px;
        color: #FFFFFF;
    }
    
    .trans_info_webinar-header-container-left-info-item img {
        margin-right: 12.06%;
    }
    
    .trans_info_webinar-header-container-right {
        height: 100%;
        width: 35%;
        
        display: flex;
        justify-content: flex-end;
    }
    
    .trans_info_webinar-header-container-right-box {
        height: 37px;
        
        display: flex;
        align-items: center;
        flex-direction: row;
    }
    
    .trans_info_webinar-header-container-right-box p {
        margin-left: 11px;
        
        color: #FFFFFF;
        font-size: 16px;
        font-weight: 600;
    }
    
    .trans_info_webinar-header-container-right-box p span {
        font-size: 10px;
        font-weight: lighter;
    }
</style>
