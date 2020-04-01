$("#events_mega_modal").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_event",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t?Swal.fire({icon:"success",title:"Успешно!",text:"Мероприятие создано"}).then(function(){window.location="/cabinet/events"}):"already"==t?Swal.fire({icon:"warning",title:"Упс!",text:"Мероприятие с подобным названием уже есть"}):Swal.fire({icon:"danger",title:"Ошибка!",text:"Произошла непредвиденная ошибка, отчет отправлен в тех.поддержку"})}})}),$(function(){$("#make_new_lectors").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_lector",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t?Swal.fire({icon:"success",title:"Успешно!",text:"Лектор создан"}).then(function(){window.location="/cabinet/lectors"}):"alrady"==t&&Swal.fire({icon:"warning",title:"Ошибка!",text:"Такой лектор уже существует"})}})}),$(".edit_lectors_cool").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_lector_edit",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t&&Swal.fire({icon:"success",title:"Успешно!",text:"Лектор изменен"}).then(function(){window.location="/cabinet/lectors"})}})}),$("#new_site_form").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_new_site",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t?Swal.fire({icon:"success",title:"Успешно!",text:"Сайт создан"}).then(function(){window.location="/cabinet/site"}):"FailSize"==t?Swal.fire({icon:"warning",title:"Ошибка!",text:"Вы пытаетесь загрузить изображение больше 2Мб"}):"Fail"==t&&Swal.fire({icon:"warning",title:"Ошибка!",text:"Обратитесь в тех. поддержку"})}})}),$("#edit_site_form").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_site_edit",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t?Swal.fire({icon:"success",title:"Успешно!",text:"Сайт изменен"}).then(function(){window.location="/cabinet/site"}):"FailSize"==t?Swal.fire({icon:"warning",title:"Ошибка!",text:"Вы пытаетесь загрузить изображение больше 2Мб"}):"Fail"==t&&Swal.fire({icon:"warning",title:"Ошибка!",text:"Обратитесь в тех. поддержку"})}})}),$("#change_profile_form").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData;e.find(":input[name]").not('[type="file"]').each(function(){var t=$(this);n.append(t.attr("name"),t.val())});var a=e.find('input[type="file"]'),i=a.attr("name"),c=a.prop("files")[0];n.append(i,c);$.ajax({url:"/catch/catch_profile_edit",type:"POST",data:n,contentType:!1,cache:!1,processData:!1,success:function(t){"ok"==t&&Swal.fire({icon:"success",title:"Успешно!",text:"Профиль успешно изменен"}).then(function(){window.location="/cabinet/profile"})}})}),$("#make_new_banner").on("click",function(){$.post("/catch/catch_create_new_banner",function(t){"ok"==t?window.location="/cabinet/site/banners":"FailSiteExist"==t&&Swal.fire({icon:"warning",title:"Ошибка!",text:"Для начала создайте сайт"}).then(function(){window.location="/cabinet/site"})})}),$(".banner_delete").on("click",function(){var t=$(this).parent().find(".this_banner_id").val();$.post("/catch/catch_delete_banner",{banner_id:t},function(t){"ok"==t&&(window.location="/cabinet/site/banners")})}),$(".delete-confirm__group .ask_yes").on("click",function(){var t=$(this).parent().find(".this_banner_id").val();$.post("/catch/catch_delete_banner",{banner_id:t},function(t){"ok"==t&&(window.location="/cabinet")})}),$(".banner_send_form").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_update_banner",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t&&Swal.fire({icon:"success",title:"Успешно!",text:"Баннер обновлен"}).then(function(){window.location="/cabinet/site/banners"})}})})}),$(".review_send_form").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_new_review",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t&&Swal.fire({icon:"success",title:"Успешно!",text:"Отзыв успешно создан"}).then(function(){window.location="/cabinet/site/comment"})}})}),$(".reviews__delete").on("click",function(){var t=$(this).parent().find(".this_comment_id").val();$.post("/catch/catch_delete_review",{review_id:t},function(t){"ok"==t&&(window.location="/cabinet/site/comment")})}),$("#make_new_admin_banner").on("click",function(){$.post("/catch/catch_create_main_banner",function(t){"ok"==t&&(window.location="/cabinet/banners")})}),$(".main_banner_send_form").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_update_main_banner",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t&&Swal.fire({icon:"success",title:"Успешно!",text:"Баннер обновлен"}).then(function(){window.location="/cabinet/banners"})}})}),$(".main_banner_delete").on("click",function(){var t=$(this).parent().find(".this_banner_id").val();$.post("/catch/catch_delete_main_banner",{banner_id:t},function(t){"ok"==t&&(window.location="/cabinet/banners")})}),$(".main_ad_send_form").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/catch/catch_update_main_ad",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t&&Swal.fire({icon:"success",title:"Успешно!",text:"Баннер обновлен"}).then(function(){window.location="/cabinet/ad"})}})}),$("#apixml").on("submit",function(t){t.preventDefault();var e=$(this),n=new FormData(e.get(0));$.ajax({url:"/api/make/byxml/event",contentType:!1,processData:!1,data:n,type:"POST",success:function(t){"ok"==t&&Swal.fire({icon:"success",title:"Успешно!",text:"Баннер обновлен"}).then(function(){window.location="/cabinet/ad"})}})}),$("#send_request").on("click",function(){let t=$("#event_request_id").val();if($("#request_surname").length){let e=$("#request_surname").val()+" "+$("#request_name").val()+" "+$("#request_fathername").val(),n=$("#request_city").val(),a=$("#request_phone").val(),i=$("#request_email").val(),c=$("#reviews-texrarea").val();$.post("/catch/catch_event_request",{event_id:t,full_name:e,city:n,phone:a,email:i,comment:c},function(t){"ok"==t?Swal.fire({icon:"success",title:"Успешно!",text:"Вы записаны на мероприятие"}).then(function(){$("#send_request").text("Вы записаны")}):"FailSize"==t&&Swal.fire({icon:"warning",title:"Ошибка!",text:"Что-то пошло не так"})})}else $.post("/catch/catch_event_request",{event_id:t},function(t){"ok"==t?Swal.fire({icon:"success",title:"Успешно!",text:"Вы записаны на мероприятие"}).then(function(){$("#send_request").text("Вы записаны")}):"FailSize"==t&&Swal.fire({icon:"warning",title:"Ошибка!",text:"Что-то пошло не так"})})}),$("#upd_btn").on("click",function(){var t=$("#pass_first").val(),e=$("#pass_second").val(),n=$("#key").val();""!=t&&t==e?$.post("/catch_recovere",{pass_first:t,pass_second:e,key:n},function(t){"ok"==t&&Swal.fire({icon:"success",title:"Пароль изменен!",text:"Сейчас Вы будете перенаправлены на страницу входа"}).then(function(){window.location.replace("/login")})}):Swal.fire({icon:"warning",title:"Ошибка!",text:"Введенные пароли не совпадают"})}),$("#edit_event_form").on("submit",function(t){let e=CKEDITOR.instances.editor1.getData();$("#editor1").html(e),t.preventDefault();var n=$(this),a=new FormData(n.get(0));$.ajax({url:"/catch/catch_event_edit",contentType:!1,processData:!1,data:a,type:"POST",success:function(t){"ok"==t&&Swal.fire({icon:"success",title:"Успешно!",text:"Мероприятие успешно изменено"}).then(function(){location.reload()})}})}),$(".inprogressnow").on("click",function(){Swal.fire({icon:"success",title:"Подождите",text:"Мы прямо сейчас разрабатываем этот функционал."})});