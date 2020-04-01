<template>
    <input type="checkbox" class="switch_1" :disabled="isDisabled">
</template>

<script>
export default {
    name: 'Checkbox_Custom1',
    props: {
        isDisabled: false
    },
}
</script>

<style>
/* Switch 1 Specific Styles Start */
.switch_1{
    font-size: 30px;
    -webkit-appearance: none;
       -moz-appearance: none;
            appearance: none;
    width: 45px; /*ширина чекбокса*/
    height: 21px; /*высота чекбакса*/
    background: #ddd;
    border-radius: 3em;
    position: relative;
    cursor: pointer;
    outline: none;
    -webkit-transition: background .2s ease-in-out;
    transition: background .2s ease-in-out;

    margin: 0;
  }

    /*цвет фона*/
  input[type="checkbox"].switch_1:checked{
    background: #2C78F6;
  }

    /*отображение кружка*/
  input[type="checkbox"].switch_1:after{
    position: absolute;
    content: "";
    width: 21px; /*ширина кружка*/
    height: 21px; /*высота кружка*/
    border-radius: 50%;
    background: #fff;
    -webkit-box-shadow: 0 0 .25em rgba(0,0,0,.3);
            box-shadow: 0 0 .25em rgba(0,0,0,.3);
    -webkit-transform: scale(.7);
            transform: scale(.7);
    left: 0;
    -webkit-transition: left .2s ease-in-out;
    transition: left .2s ease-in-out;
  }

    /*движение кружка*/
  input[type="checkbox"].switch_1:checked:after{
    left: calc(100% - 21px);
  }

/* Switch 1 Specific Style End */
</style>
