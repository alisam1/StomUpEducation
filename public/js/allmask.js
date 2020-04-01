

$(window).ready(function(){
  /* Registration */
    $("#phone_org").inputmask("+9 (999) 999-99-99");
    $("#phone_hide").inputmask("+9 (999) 999-99-99");
    $('#phone_people').inputmask("+9 (999) 999-99-99");
    $('#email_org').inputmask("email");

    /* Login */
    $("#phone_org").inputmask("+9 (999) 999-99-99");
    $("#phone_hide").inputmask("+9 (999) 999-99-99");
    $('#phone_people').inputmask("+9 (999) 999-99-99");


  /* Profile_edit */
    $('#profile_phone').inputmask("+9 (999) 999-99-99");
    $('#profile_mail').inputmask("email");

  /* PopUps */
  //Events
  //Находятся прямо в визарде шагов
  //Lectors
    $('#form__top--phone').inputmask("+9 (999) 999-99-99");
    $('#form__top--mail').inputmask("email");
    $('.form__top--phone').inputmask("+9 (999) 999-99-99");
    $('.form__top--mail').inputmask("email");

    //CreateSite
    $('#create-phone').inputmask("+9 (999) 999-99-99");
    $('#create-mail').inputmask("email");
    $('#site_worktime_from').inputmask("99:99");
    $('#site_worktime_to').inputmask("99:99");

    //Webinars
    $('.webinar_time_mask').inputmask("99:99");
    $('.webinar_date_mask').inputmask("99.99.9999");

    //all
    $('.thisistimemask').inputmask("99:99");
    $('.thisisdatemask').inputmask("99.99.9999");

  });
