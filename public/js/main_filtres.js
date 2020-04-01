$(function(){
	$(".main-select__button").click(function(){

		$('.main-select-bottom').slideToggle(300, function(){

			if ($(this).is(':hidden')) {

				$('.main-select__button').html('Показать все фильтры');

			} else {

				$('.main-select__button').html('Скрыть фильтры');

			}							

		});

		return false;

	});
});

$(function(){
	$('.block__events').click(function(e){
		e.preventDefault();
		$(this).toggleClass("active");
		return false;
	});
});