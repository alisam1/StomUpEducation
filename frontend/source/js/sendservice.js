//----------
//Создание нового мироприятия
$('#events_mega_modal').on('submit', function(e){
  e.preventDefault();
  var $that = $(this),
  formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
  $.ajax({
    url: '/catch/catch_event',
    contentType: false, // важно - убираем форматирование данных по умолчанию
    processData: false, // важно - убираем преобразование строк по умолчанию
    data: formData,
    type: 'POST',
    success: function(data){

      if(data == 'ok'){

        Swal.fire({
        icon: 'success',
        title: 'Успешно!',
        text: 'Мероприятие создано',
      }).then(function() {
          window.location = "/cabinet/events";
      });

    } else if (data == 'already') {

      Swal.fire({
      icon: 'warning',
      title: 'Упс!',
      text: 'Мероприятие с подобным названием уже есть',
      });

    } else {
      //// TODO: Сделать автоматическую отправку отчета в тех отдел
      Swal.fire({
      icon: 'danger',
      title: 'Ошибка!',
      text: 'Произошла непредвиденная ошибка, отчет отправлен в тех.поддержку',
      });

    }

    }
  });
});
//----------
//Создание нового лектора
$(function(){
$('#make_new_lectors').on('submit', function(e){
e.preventDefault();
var $that = $(this),
formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
$.ajax({
  url: '/catch/catch_lector',
  contentType: false, // важно - убираем форматирование данных по умолчанию
  processData: false, // важно - убираем преобразование строк по умолчанию
  data: formData,
  type: 'POST',
  success: function(data){

    if(data == 'ok'){

      Swal.fire({
      icon: 'success',
      title: 'Успешно!',
      text: 'Лектор создан',
    }).then(function() {
        window.location = "/cabinet/lectors";
    });

  } else if (data == 'alrady') {

    Swal.fire({
    icon: 'warning',
    title: 'Ошибка!',
    text: 'Такой лектор уже существует',
  });

  }

  }
});
});

//Изменение лектора
$('.edit_lectors_cool').on('submit', function(e){
e.preventDefault();
var $that = $(this),
formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
$.ajax({
  url: '/catch/catch_lector_edit',
  contentType: false, // важно - убираем форматирование данных по умолчанию
  processData: false, // важно - убираем преобразование строк по умолчанию
  data: formData,
  type: 'POST',
  success: function(data){

    if(data == 'ok'){

      Swal.fire({
      icon: 'success',
      title: 'Успешно!',
      text: 'Лектор изменен',
    }).then(function() {
        window.location = "/cabinet/lectors";
    });

    }

  }
});
});


//Создание сайта
$('#new_site_form').on('submit', function(e){
e.preventDefault();
var $that = $(this),
formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
$.ajax({
  url: '/catch/catch_new_site',
  contentType: false, // важно - убираем форматирование данных по умолчанию
  processData: false, // важно - убираем преобразование строк по умолчанию
  data: formData,
  type: 'POST',
  success: function(data){

    if(data == 'ok'){

      Swal.fire({
      icon: 'success',
      title: 'Успешно!',
      text: 'Сайт создан',
    }).then(function() {
        window.location = "/cabinet/site";
    });

  } else if (data == 'FailSize') {
          Swal.fire({
          icon: 'warning',
          title: 'Ошибка!',
          text: 'Вы пытаетесь загрузить изображение больше 2Мб',
        });

  } else if(data == 'Fail') {
    Swal.fire({
    icon: 'warning',
    title: 'Ошибка!',
    text: 'Обратитесь в тех. поддержку',
  });
  }

  }
});
});


//Редактирование сайта
$('#edit_site_form').on('submit', function(e){
e.preventDefault();
var $that = $(this),
formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
$.ajax({
  url: '/catch/catch_site_edit',
  contentType: false, // важно - убираем форматирование данных по умолчанию
  processData: false, // важно - убираем преобразование строк по умолчанию
  data: formData,
  type: 'POST',
  success: function(data){

    if(data == 'ok'){

      Swal.fire({
      icon: 'success',
      title: 'Успешно!',
      text: 'Сайт изменен',
    }).then(function() {
        window.location = "/cabinet/site";
    });

  } else if (data == 'FailSize') {
          Swal.fire({
          icon: 'warning',
          title: 'Ошибка!',
          text: 'Вы пытаетесь загрузить изображение больше 2Мб',
        });

  } else if(data == 'Fail') {
    Swal.fire({
    icon: 'warning',
    title: 'Ошибка!',
    text: 'Обратитесь в тех. поддержку',
  });
  }

  }
});
});



//Редактирование профиля пользователя
$('#change_profile_form').on('submit', function(e){
    e.preventDefault()
    var form = $(this); // Предположу, что этот код выполняется в обработчике события 'submit' формы
    var data = new FormData();

    // Сбор данных из обычных полей
    form.find(':input[name]').not('[type="file"]').each(function() {
        var field = $(this);
        data.append(field.attr('name'), field.val());
    });



    // Сбор данных о файле (будет немного отличаться для нескольких файлов)
    var filesField = form.find('input[type="file"]');
    var fileName = filesField.attr('name');
    var file = filesField.prop('files')[0];
    data.append(fileName, file) ;



    // Отправка данных
    var url = '/catch/catch_profile_edit';

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if(data == 'ok'){

              Swal.fire({
              icon: 'success',
              title: 'Успешно!',
              text: 'Профиль успешно изменен',
            }).then(function() {
                window.location = "/cabinet/profile";
            });

            }
        }
    });
});


//Создание нового баннера в личном кабинете пользователя
$('#make_new_banner').on('click', function(){
  $.post('/catch/catch_create_new_banner', function(data){
    if(data == 'ok'){

      window.location = "/cabinet/site/banners";


    } else if (data == 'FailSiteExist') {

      Swal.fire({
      icon: 'warning',
      title: 'Ошибка!',
      text: 'Для начала создайте сайт',
    }).then(function() {
        window.location = "/cabinet/site";
    });

    }
  });
});



//Удаление баннера
$('.banner_delete').on('click',function(){

  var banner_id = $(this).parent().find('.this_banner_id').val();

  $.post('/catch/catch_delete_banner', {
    'banner_id':banner_id
  }, function(data){
    if(data == 'ok'){
      window.location = "/cabinet/site/banners";
    }
  });

});

//Удаление баннера из внешнего интерфейса кабинета

$('.delete-confirm__group .ask_yes').on('click',function(){

  var banner_id = $(this).parent().find('.this_banner_id').val();

  $.post('/catch/catch_delete_banner', {
    'banner_id':banner_id
  }, function(data){
    if(data == 'ok'){
      window.location = "/cabinet";
    }
  });

});

//Редактирование баннера
$('.banner_send_form').on('submit', function(e){

//
  e.preventDefault();
  var $that = $(this),
  formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
  $.ajax({
    url: '/catch/catch_update_banner',
    contentType: false, // важно - убираем форматирование данных по умолчанию
    processData: false, // важно - убираем преобразование строк по умолчанию
    data: formData,
    type: 'POST',
    success: function(data){

      if(data == 'ok'){

        Swal.fire({
        icon: 'success',
        title: 'Успешно!',
        text: 'Баннер обновлен',
      }).then(function() {
          window.location = "/cabinet/site/banners";
      });

    }

    }
  });

});

});


//Создание нового отзыва
$('.review_send_form').on('submit', function(e){

//
  e.preventDefault();
  var $that = $(this),
  formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
  $.ajax({
    url: '/catch/catch_new_review',
    contentType: false, // важно - убираем форматирование данных по умолчанию
    processData: false, // важно - убираем преобразование строк по умолчанию
    data: formData,
    type: 'POST',
    success: function(data){

      if(data == 'ok'){

        Swal.fire({
        icon: 'success',
        title: 'Успешно!',
        text: 'Отзыв успешно создан',
      }).then(function() {
          window.location = "/cabinet/site/comment";
      });

    }

    }
  });

});

//Удаление отзыва
$('.reviews__delete').on('click', function(){
  var review_id = $(this).parent().find('.this_comment_id').val();

  // console.log(review_id);

  $.post('/catch/catch_delete_review', {
    'review_id':review_id
  }, function(data){
    if(data == 'ok'){
      window.location = "/cabinet/site/comment";
    }
  });

});


//Создание нового админ баннера в личном кабинете админа
$('#make_new_admin_banner').on('click', function(){
  $.post('/catch/catch_create_main_banner', function(data){

    if(data == 'ok'){

      window.location = "/cabinet/banners";


    }

  });
});


//Редактирование баннера
$('.main_banner_send_form').on('submit', function(e){

//
  e.preventDefault();
  var $that = $(this),
  formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
  $.ajax({
    url: '/catch/catch_update_main_banner',
    contentType: false, // важно - убираем форматирование данных по умолчанию
    processData: false, // важно - убираем преобразование строк по умолчанию
    data: formData,
    type: 'POST',
    success: function(data){

      if(data == 'ok'){

        Swal.fire({
        icon: 'success',
        title: 'Успешно!',
        text: 'Баннер обновлен',
      }).then(function() {
          window.location = "/cabinet/banners";
      });

    }

    }
  });

});


//Удаление main banner
//Удаление баннера
$('.main_banner_delete').on('click',function(){

  var banner_id = $(this).parent().find('.this_banner_id').val();

  $.post('/catch/catch_delete_main_banner', {
    'banner_id':banner_id
  }, function(data){
    if(data == 'ok'){
      window.location = "/cabinet/banners";
    }
  });

});



//Редактирование рекламы
$('.main_ad_send_form').on('submit', function(e){

//
  e.preventDefault();
  var $that = $(this),
  formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
  $.ajax({
    url: '/catch/catch_update_main_ad',
    contentType: false, // важно - убираем форматирование данных по умолчанию
    processData: false, // важно - убираем преобразование строк по умолчанию
    data: formData,
    type: 'POST',
    success: function(data){

      if(data == 'ok'){

        Swal.fire({
        icon: 'success',
        title: 'Успешно!',
        text: 'Баннер обновлен',
      }).then(function() {
          window.location = "/cabinet/ad";
      });

    }

    }
  });

});


//API::Отправка XML
$('#apixml').on('submit', function(e){

//
  e.preventDefault();
  var $that = $(this),
  formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
  $.ajax({
    url: '/api/make/byxml/event',
    contentType: false, // важно - убираем форматирование данных по умолчанию
    processData: false, // важно - убираем преобразование строк по умолчанию
    data: formData,
    type: 'POST',
    success: function(data){

      if(data == 'ok'){

        Swal.fire({
        icon: 'success',
        title: 'Успешно!',
        text: 'Баннер обновлен',
      }).then(function() {
          window.location = "/cabinet/ad";
      });

    }

    }
  });

});


//Создание заявки на мероприятие от пользователя
$('#send_request').on('click', function(){
  let event_id = $('#event_request_id').val();

  //Проверить на существование input с данными
  if($('#request_surname').length){
  let request_surname = $('#request_surname').val();
  let request_name = $('#request_name').val();
  let request_fathername = $('#request_fathername').val();
  let full_name = request_surname + ' ' +request_name+ ' ' +request_fathername;
  let city = $('#request_city').val();
  let phone = $('#request_phone').val();
  let email = $('#request_email').val();
  let comment = $('#reviews-texrarea').val();

  $.post('/catch/catch_event_request', {
    'event_id':event_id,
    'full_name':full_name,
    'city':city,
    'phone':phone,
    'email':email,
    'comment':comment
  }, function(data){

    if(data == 'ok'){

          Swal.fire({
          icon: 'success',
          title: 'Успешно!',
          text: 'Вы записаны на мероприятие',
        }).then(function() {
            $('#send_request').text('Вы записаны');
        });

      } else if (data == 'FailSize') {
              Swal.fire({
              icon: 'warning',
              title: 'Ошибка!',
              text: 'Что-то пошло не так',
            });

      }

  });

} else {

  $.post('/catch/catch_event_request', {
    'event_id':event_id
  }, function(data){

    if(data == 'ok'){

          Swal.fire({
          icon: 'success',
          title: 'Успешно!',
          text: 'Вы записаны на мероприятие',
        }).then(function() {
            $('#send_request').text('Вы записаны');
        });

      } else if (data == 'FailSize') {
              Swal.fire({
              icon: 'warning',
              title: 'Ошибка!',
              text: 'Что-то пошло не так',
            });

      }

  });

}

});


//Сброс пароля
$('#upd_btn').on('click', function(){
  var pass_first = $('#pass_first').val();
  var pass_second = $('#pass_second').val();
  var key = $('#key').val();

  if(pass_first != '' && pass_first == pass_second ){

    $.post('/catch_recovere', {
      'pass_first':pass_first,
      'pass_second':pass_second,
      'key':key
    }, function(data){
      if(data == 'ok'){

        Swal.fire({
        icon: 'success',
        title: 'Пароль изменен!',
        text: 'Сейчас Вы будете перенаправлены на страницу входа',
      }).then(function() {
          window.location.replace("/login");
      });

      }
    });

  } else {
    Swal.fire({
    icon: 'warning',
    title: 'Ошибка!',
    text: 'Введенные пароли не совпадают',
  });
  }
});


//Изменение мероприятия
$('#edit_event_form').on('submit', function(e){

let textAreaData = CKEDITOR.instances.editor1.getData();

$('#editor1').html(textAreaData);

//
  e.preventDefault();
  var $that = $(this),
  formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
  $.ajax({
    url: '/catch/catch_event_edit',
    contentType: false, // важно - убираем форматирование данных по умолчанию
    processData: false, // важно - убираем преобразование строк по умолчанию
    data: formData,
    type: 'POST',
    success: function(data){


      if(data == 'ok'){

        Swal.fire({
        icon: 'success',
        title: 'Успешно!',
        text: 'Мероприятие успешно изменено',
      }).then(function() {
          location.reload();
      });

    }

    }
  });

});

//Общая уведомлялка для разрабатываемого функционала
$('.inprogressnow').on('click', function(){
  Swal.fire({
  icon: 'success',
  title: 'Подождите',
  text: 'Мы прямо сейчас разрабатываем этот функционал.',
});
});
