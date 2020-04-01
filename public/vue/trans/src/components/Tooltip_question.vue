<template>
    <div class="tooltip_question">
        <img src="@/assets/icon_question.svg" alt="question" />
        <div class="tooltip_question_container">
            <p>{{ textMessage }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Tooltip_question',
        props: {
            textMessage: String,
        }
    }
</script>

<style scoped="true">
    .tooltip_question {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        position: relative;
        margin: 0;
        padding: 0;
    }
    
    .tooltip_question:hover .tooltip_question_container {
        visibility: visible;
    }
    
    .tooltip_question_container {
        visibility: hidden;
        position: absolute;
        top: -25spx;
        left: 28px;
        
        padding-left: 16px;
        padding-right: 12px;
        padding-top: 12px;
        padding-bottom: 14px;
        width: 283px;
        height: auto;
        
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 1px 1px 10px rgba(129, 129, 129, 0.25);
        z-index: 2000;
    }
    
    .tooltip_question_container p {
        color: #333333;
        font-size: 10px;
        line-height: 12px;
        font-weight: lighter;
        
        margin: 0;
        padding: 0;
    }
</style>
