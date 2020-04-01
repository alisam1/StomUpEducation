/* Events */

(function ($) {
  function setChecked(target) {
    var checked = $(target).find("input[type='checkbox']:checked").length;
    if (checked) {
      $(target).find('div label:first').html('Выбрано: ' + checked);
    } else {
      
      if($(target).hasClass('checkselect_lectors')){
        $(target).find('div label:first').html('Выберите лектора');
      }else {
        $(target).find('div label:first').html('Выберите тип мероприятия');
      }

    }
  }

  $.fn.checkselect = function () {
    this.wrapInner('<div class="checkselect-popup"></div>');
    this.prepend(
      '<div class="checkselect-control">' +
      '<div class="form-control"><label></label></div>' +
      '<div class="checkselect-over"></div>' +
      '</div>'
    );

    this.each(function () {
      setChecked(this);
    });
    this.find('input[type="checkbox"]').click(function () {
      setChecked($(this).parents('.checkselect'));
    });

    this.parent().find('.checkselect-control').on('click', function () {
      $popup = $(this).next();
      $('.checkselect-popup').not($popup).css('display', 'none');
      if ($popup.is(':hidden')) {
        $popup.css('display', 'block');
        $(this).find('div').focus();
      } else {
        $popup.css('display', 'none');
      }
    });

    $('html, body').on('click', function (e) {
      if ($(e.target).closest('.checkselect').length == 0) {
        $('.checkselect-popup').css('display', 'none');
      }
    });
  };
})(jQuery);

$('.checkselect').checkselect();
