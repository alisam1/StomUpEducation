

$('.registration-form .registration-page:first-child').fadeIn('slow');

if ($(window).width() > 767) {
    $('.registration-page--mobile').css("display", "none");
    //$('.registration-form .registration-page:first-child').hide();
    $('.registration-form .registration-page:nth-child(2)').show();
} else {
  $('.registration-form .registration-page:nth-child(2)').css("display", "none");
  //$('.registration-form .registration-page:first-child').hide();
  $('.registration-page--mobile').show();
}

/* Hide phone */
$(function(){
    $("a.hide-phone__link").click(function () {
        $(".hide-form__input").slideToggle("slow");
    });
});



    //POST for BackEnd
    $('.button__away--login').on('click',function(){

      //Событие логина собираем переменные
      var login = $('#phone_org').val();
      var pass = $('#password').val();

      //Если поля заполненны
      if(login != '' && pass != ''){

        //Зона работы с сервером
        $.post(
          '/catch/catch_login',
          {
            login: login,
            password: pass
          }, function( data ){
            //Если data будет ok - то редиректим куда то
            if( data == 'ok' ){
              window.location.replace('/cabinet');
            } else if (data == 'auth_fail') {

              Swal.fire({
              icon: 'warning',
              title: 'Упс!',
              text: 'Неверно указан логин или пароль',
              });

            }

          }
        );

      } else {

        Swal.fire({
        icon: 'warning',
        title: 'Упс!',
        text: 'Не указаны логин и пароль!',
        });
        
      }


    });

    //Кнопка забыли пароль
    $('#recover_acc').on('click', function(){
      var login = $('#phone_org').val();
      var addr = $(this).attr('data-way');
      var good_url_to_recover = addr + '?phoner=' + login;

      window.location.replace(good_url_to_recover);
    });
