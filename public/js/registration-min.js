function openTab(t){var s,e=document.getElementsByClassName("city");for(s=0;s<e.length;s++)e[s].style.display="none";(document.getElementById(t).style.display="block")&&document.querySelector(".tabs__item").classList.add("active")}$(function(){$("a.hide-phone__link").click(function(){$(".hide-form__input").slideToggle("slow")})}),$(".tabs__item--people").on("click",function(){$("#whats_choose").val("2"),$("#People .registration-form .registration-page:nth-child(2)").css("display","none")}),$(".tabs__item--ed").on("click",function(){$("#whats_choose").val("1")}),$(".registration-form .registration-page:first-child").fadeIn("slow"),$('.registration-form input[type="text"]').on("focus",function(){$(this).removeClass("input-error")}),$('input[type="text"]').focus(function(){$(".input-error__message").css("display","none")}),$('input[type="[password]"]').focus(function(){$(".input-error__message").css("display","none")}),$("input").on("change paste keyup focusout focusin",function(){""!=$(this).val()?$(this).addClass("input-success"):""==$(this).val()&&$(this).removeClass("input-success")}),$('input[type="text"] , input[type="password"]').on("change paste keyup",function(){"1"==$("#whats_choose").val()?(""==$("#password").val()||""==$(this).val()&&"phone_hide"!=$(this).attr("id")&&"photo_file"!=$(this).attr("id")?$(".button__further").removeClass("active"):$(".button__further").addClass("active"),""!=$("#address").val()&&""!=$("#address_fact").val()&&$(".button__registr").addClass("active")):(""==$("#password_user").val()||""==$(this).val()&&"phone_hide"!=$(this).attr("id")&&"photo_file"!=$(this).attr("id")?$(".button__further").removeClass("active"):$(".button__further").addClass("active"),""!=$("#fio").val()&&""!=$("#position").val()&&""!=$("#address_work").val()&&$(".button__registr").addClass("active"))}),$(window).width()>767&&($(".registration-page--mobile").css("display","none"),$(".registration-form .registration-page:nth-child(2)").show()),$(".registration-form .btn-next").on("click",function(){var t=$(this).parents(".registration-page"),s=!0;t.find('input[type="text"]').each(function(){""==$(this).val()&&"phone_hide"!=$(this).attr("id")&&"photo_file"!=$(this).attr("id")?($(this).addClass("input-error"),$(this).removeClass("input-success"),$(this).parent().children(".input-error__message").css("display","block"),$(".button__further").removeClass("active"),$(window).width()<767&&$(".input-error__message").css("display","none"),s=!1):($(this).removeClass("input-error"),$(this).addClass("input-success"),$(this).parent().children(".input-error__message").css("display","none"),$(".button__further").addClass("active"))}),t.find('input[type="password"]').each(function(){""==$(this).val()&&"phone_hide"!=$(this).attr("id")&&"photo_file"!=$(this).attr("id")?($(this).addClass("input-error"),$(this).removeClass("input-success"),$(".button__further").removeClass("active"),$(this).parent().children(".input-error__message").css("display","block"),$(window).width()<767&&$(".input-error__message").css("display","none"),s=!1):($(this).removeClass("input-error"),$(this).addClass("input-success"),$(".button__further").addClass("active"),$(this).parent().children(".input-error__message").css("display","none"))}),s&&t.fadeOut(400,function(){$(this).next().fadeIn(),$(".step").addClass("active")})}),$(".registration-form .btn-previous").on("click",function(){$(this).parents(".registration-page").fadeOut(400,function(){$(this).prev().fadeIn()})}),$(".registration-form .button__registr").on("click",function(){$(this).parents(".registration-page").find('input[type="text"]').each(function(){""==$(this).val()?($("#whats_check").val("false"),e.preventDefault(),$(this).addClass("input-error"),$(this).removeClass("input-success"),$(window).width()<767?$(".input-error__message").css("display","none"):$(".input-error__message").css("display","block")):($("#whats_check").val("true"),$(this).removeClass("input-error"),$(this).addClass("input-success"),$(this).removeClass("input-error__message"))})}),$(".registration-form .button__registr").on("click",function(){if("true"==$("#whats_check").val()){var t=$("#whats_choose").val();if("1"==t){var s=$("#phone_org").val(),e=($("#phone_hide").val(),$("#name_org").val()),i=$("#email_org").val(),a=$("#inn_org").val(),r=$("#kpp_org").val(),n=$("#ur_org").val(),o=$("#address").val(),l=$("#address_fact").val(),c=$("#password").val();$.post("/catch/catch_registration",{login:s,password:c,email:i,phone:s,type:t,full_name:e,inn:a,kpp:r,ogrn:"",jur_name:n,jur_address:o,fiz_address:l},function(t){"ok"==t?window.location.replace("/cabinet"):"already"==t?alert("Такой пользователь уже существует"):"Fail"==t&&alert("Непредвиденная ошибка. Обратитесь в тех. поддержку")})}else if("2"==t){var p=$("#phone_people").val(),d=(c=$("#password_user").val(),$("#fio").val()),u=$("#position").val(),h=$("#address_work").val();$.post("/catch/catch_registration",{login:p,password:c,email:"",phone:p,type:t,full_name:d,worker_position:u,worker_city:h},function(t){"ok"==t?window.location.replace("/cabinet"):"already"==t?alert("Такой пользователь уже существует"):"Fail"==t&&alert("Непредвиденная ошибка. Обратитесь в тех. поддержку")})}}});