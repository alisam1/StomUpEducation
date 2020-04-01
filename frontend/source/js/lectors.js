/* Select + checkbox */

$(".dropdown dt a").on('click', function () {
  $(".dropdown dd ul").slideToggle('fast');
});

$(".dropdown dd ul li a").on('click', function () {
  $(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return $("#" + id).find("dt a span.value").html();
}

$(document).bind('click', function (e) {
  var $clicked = $(e.target);
  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
});

$(function (){
  var $text = $('.text-input'),
      $box = $('.my-checkbox');

  $box.on('click change', function() {
    var values = [];

    $box.filter(':checked').each(function() {
      values.push(this.value);
    });

    $text.val(values.join(', '));
  });
});
