/* Header/sidebar/footer new */


$(window).scroll(function () {
 var headerHeight = $('.main-header').innerHeight();
 var contentHeight = $('.main-center__right').innerHeight();
 var sidebarHeight = $('.sidebar').height();
 var sidebarBottomPos = contentHeight - sidebarHeight;
 var trigger = $(window).scrollTop() - headerHeight;

			 if ($(window).scrollTop() >= headerHeight) {
					 $('.sidebar').addClass('fixed');
			 } else {
					 $('.sidebar').removeClass('fixed');
			 }

			 /*if (trigger >= sidebarBottomPos) {
					 $('.sidebar').addClass('bottom');
			 } else {
					 $('.sidebar').removeClass('bottom');
			 } */
});


$(document).ready(function() {
    $('#menuToggle').click(function() {
        $(this).toggleClass('active');
    })
})