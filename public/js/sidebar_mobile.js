$(function() {
           $('.mobile-menu__button').click(function(){
              $('.mobile-menu__sidebar').stop().fadeToggle();
            });
        });

$(document).ready(function () {
        var searchBlock = $('#form');
        $(document).on('click', '#open', function () {
        searchBlock.slideToggle();
        return false;
    });
});

$(document).ready(function () {
    var searchBlock = $('#form_desktop');
    $(document).on('click', '#open_desktop', function () {
    searchBlock.slideToggle();
    return false;
});
});


$(document).ready(function () {
	$(window).on("scroll", function() {
          if ($(window).scrollTop() > 0) {
            // console.log("111")
			$('.template-header__main').css("display", "none");
            $('.template-center-header').css({ "top": "0px"});
		}else{
            $('.template-header__main').css("display", "block");
            $('.template-center-header').css({ "top": "26px"});
		}
          });
});
