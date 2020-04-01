/* Chats */
$(function () {
  $('.myvertical-tabs').delegate('li:not(.chosen)', 'click', function () {
    $(this).addClass('chosen').siblings().removeClass('chosen')
      .parents('.wrap-myvertical-tabs').find('.myvertical-tabs-content')
      .hide().eq($(this).index()).fadeIn(170);
  });
});

$(document).ready(function () {
  $('.add__button').on("click", function () {
    $('.add__hide').toggle();
  });
});

$(function () {
  $('.chats__person').on("click", function () {
    var chat_id = $(this).attr("id");
    var replc = chat_id.replace('person-', '');
    var chat_window_id = '#content-' + replc + '';
    var chat_mobile_hidden_id = '#content-' + replc + ' .mobile__hidden';
    $(".chats__desktop").each(function () {
      $(this).css('display', 'none');
    });
    $(chat_window_id).css("display", "block");
    $(chat_mobile_hidden_id).css("display", "block");
  });
});


$(function () {
  $('.chats__away').on("click", function () {
    $('.mobile__hidden').css("display", "none");
  });
});


/* Chats new */

$(function () {
  $('.chats__person').each(function () {
    var text_id = $(this).attr("id");
    var replc_title =  text_id.replace('person-', '');
    // console.log(replc_title);
    var chat_text_id = '#content-' + replc_title + ' .chats__text-last';
    // console.log(chat_text_id);
    /*var chat_text_id = chat_id + '.chats__text-last';*/
    var str  = $(chat_text_id).text();
    // console.log(str);
    var message = str.substr(0, 32) + '...';
    $('#' + text_id + " .chats__text").html(message);
  });
});


$(".chats__person").click(function(){
  $(".chats__area").animate({scrollTop: $("body").height()+ 9999 },"slow");

  return false;});
