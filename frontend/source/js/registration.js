    /* Hide phone */
    $(function(){
        $("a.hide-phone__link").click(function () {
            $(".hide-form__input").slideToggle("slow");
        });
    });

    /*
       Tabs
    */

   function openTab(cityName) {
    var i;
    var x = document.getElementsByClassName("city");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
    }
    if(document.getElementById(cityName).style.display = "block"){
    var elements = document.querySelector(".tabs__item");
    elements.classList.add("active");
}
  }

  //Устанавливаем переменную выбора слушателя
  $('.tabs__item--people').on('click',function(){
    $('#whats_choose').val('2');
    $('#People .registration-form .registration-page:nth-child(2)').css('display','none');
  });
  //Устанавливаем переменную выбора центра
  $('.tabs__item--ed').on('click', function(){
    $('#whats_choose').val('1');
  });

    /*
        Form
    */


$('.registration-form .registration-page:first-child').fadeIn('slow');

    $('.registration-form input[type="text"]').on('focus', function() {
    	$(this).removeClass('input-error');
    })

$('input[type="text"]').focus(function () {
    $('.input-error__message').css("display", "none");
 });

 $('input[type="[password]"]').focus(function () {
  $('.input-error__message').css("display", "none");
});

//Валидация заполненности инпут полей
$('input').on('change paste keyup focusout focusin',function(){

  if($(this).val() != ''){
    $(this).addClass('input-success');
  } else if($(this).val() == "") {
    $(this).removeClass('input-success');
  }

});

//success
$('input[type="text"] , input[type="password"]').on("change paste keyup", function () {

  if( $('#whats_choose').val() == '1' ){

    if (
      $('#password').val() == ""
    || $(this).val() == ""
    && $(this).attr('id') != "phone_hide"
    && $(this).attr('id') != "photo_file" ) {

    $('.button__further').removeClass("active");
    } else {
        $('.button__further').addClass("active");
    }

    //Делаем синей кнопку регистрации
    if($('#address').val() != '' && $('#address_fact').val() != ''){
      $('.button__registr').addClass("active");
    }

  } else {

    if (
    $('#password_user').val() == ""
    || $(this).val() == ""
    && $(this).attr('id') != "phone_hide"
    && $(this).attr('id') != "photo_file" ) {

    $('.button__further').removeClass("active");
    } else {
        $('.button__further').addClass("active");
    }

    //Делаем синей кнопку регистрации
    if($('#fio').val() != '' && $('#position').val() != '' && $('#address_work').val() != ''){
      $('.button__registr').addClass("active");
    }

  }

});



if ($(window).width() > 767) {
    $('.registration-page--mobile').css("display", "none");
    //$('.registration-form .registration-page:first-child').hide();
    $('.registration-form .registration-page:nth-child(2)').show();
}

    // next step
    $('.registration-form .btn-next').on('click', function() {
        var parent_fieldset = $(this).parents('.registration-page');
        var next_step = true;



        parent_fieldset.find('input[type="text"]').each(function() {
            if ($(this).val() == "" && $(this).attr('id') != "phone_hide" && $(this).attr('id') != "photo_file" ) {
                $(this).addClass('input-error');
                $(this).removeClass('input-success');
                $(this).parent().children('.input-error__message').css("display", "block");
                $('.button__further').removeClass("active");
                if ($(window).width() < 767) {
                    $('.input-error__message').css("display", "none");
                }
                next_step = false;
            }
    		else {
                $(this).removeClass('input-error');
                $(this).addClass('input-success');
                $(this).parent().children('.input-error__message').css("display", "none");
                $('.button__further').addClass("active");
    		}
      });

      parent_fieldset.find('input[type="password"]').each(function() {
        if ($(this).val() == "" && $(this).attr('id') != "phone_hide" && $(this).attr('id') != "photo_file" ) {
            $(this).addClass('input-error');
            $(this).removeClass('input-success');
            $('.button__further').removeClass("active");
            $(this).parent().children('.input-error__message').css("display", "block");
            if ($(window).width() < 767) {
                $('.input-error__message').css("display", "none");
            }
            next_step = false;
        }
    else {
            $(this).removeClass('input-error');
            $(this).addClass('input-success');
            $('.button__further').addClass("active");
            $(this).parent().children('.input-error__message').css("display", "none");
    }
  });

    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
                $(this).next().fadeIn();
                $(".step").addClass("active");
	    	});
    	}

    });

    // previous step
    $('.registration-form .btn-previous').on('click', function() {
        $(this).parents('.registration-page').fadeOut(400, function() {
    		$(this).prev().fadeIn();
    	});
    });

    // submit
$('.registration-form .button__registr').on('click', function() {
    var parent_fieldset = $(this).parents('.registration-page');
  // console.log('FIX');
        parent_fieldset.find('input[type="text"]').each(function() {
          //Если валидация провалена
    		if( $(this).val() == "") {
          $('#whats_check').val('false');
    			e.preventDefault();
                $(this).addClass('input-error');
                $(this).removeClass('input-success');
                if ($(window).width() < 767) {
                    $('.input-error__message').css("display", "none");
                } else
                {
                    $('.input-error__message').css("display", "block");
                }
    		}
        //Если валидация успешна
    		else {
          $('#whats_check').val('true');
          // console.log('ELSE');
                $(this).removeClass('input-error');
                $(this).addClass('input-success');
                $(this).removeClass('input-error__message');



    		}
    	});

    });

    //POST for BackEnd
    $('.registration-form .button__registr').on('click',function(){
      //Если предидущий скрипт прошел проверку и все оки, то запускаем POST
      if($('#whats_check').val() == 'true'){

      //Зона отправки POST на сервер
      var whats_choose = $('#whats_choose').val();
      //Если выбран обучающий центр
      if(whats_choose == '1'){
        //Зона переменных
        var phone_org = $('#phone_org').val();
        var phone_hide = $('#phone_hide').val();
        var name_org = $('#name_org').val();
        var email_org = $('#email_org').val();
        var inn_org = $('#inn_org').val();
        var kpp_org = $('#kpp_org').val();
        var ur_org = $('#ur_org').val();
        var address = $('#address').val();
        var address_fact = $('#address_fact').val();
        var password = $('#password').val();

        //Зона работы с сервером
        $.post(
          '/catch/catch_registration',
          {
            login: phone_org,
            password: password,
            email: email_org,
            phone: phone_org,
            type: whats_choose,
            full_name: name_org,
            inn: inn_org,
            kpp: kpp_org,
            ogrn: '',
            jur_name: ur_org,
            jur_address: address,
            fiz_address: address_fact,
          }, function( data ){

            if( data == 'ok' ){
              window.location.replace('/cabinet');
            } else if(data == 'already'){
              alert('Такой пользователь уже существует');
            }
            else if (data == 'Fail') {
              alert('Непредвиденная ошибка. Обратитесь в тех. поддержку');
            }
            //Если data будет ok - то редиректим куда то
          }
        );
      }
      //Если выбран слушатель
      else if (whats_choose == '2') {
        //Зона переменных
        var phone_people = $('#phone_people').val();
        var password = $('#password_user').val();
        var fio = $('#fio').val();
        var position = $('#position').val();
        var address_work = $('#address_work').val();


        //Зона работы с сервером
        $.post(
          '/catch/catch_registration',
          {
            login: phone_people,
            password: password,
            email: '',
            phone: phone_people,
            type: whats_choose,
            full_name: fio,
            worker_position: position,
            worker_city: address_work,
          }, function( data ){
            if( data == 'ok' ){
              window.location.replace('/cabinet');
            }  else if(data == 'already'){
              alert('Такой пользователь уже существует');
            }
            else if (data == 'Fail') {
              alert('Непредвиденная ошибка. Обратитесь в тех. поддержку');
            }
            //Если data будет ok - то редиректим куда то
          }
        );

      }

      }

    });
