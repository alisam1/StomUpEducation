jQuery(document).ready(function(e){var s=e(".template-header"),a=e(".template-header__main"),n=e(".template-center-header"),t=(s.height(),!1),d=0,i=10,o=20;function r(){var r=e(window).scrollTop();n.length>0?function(t){var r=n.offset().top-a.height()-s.height();d>=t?t<r?(s.removeClass("is-hidden"),a.removeClass("fixed slide-up"),n.removeClass("secondary-nav-fixed")):d-t>i&&(s.removeClass("is-hidden"),a.removeClass("slide-up").addClass("fixed"),n.addClass("secondary-nav-fixed"),e("a.trigger").css({top:"122px"}),e(".main-center-sidebar__laptop-sub").css({top:"60px"}),e(".panel ul").css({top:"72px"}),e(".template-center-menu").css({"padding-top":"0px"})):t>r+o?(s.addClass("is-hidden"),a.addClass("fixed slide-up"),n.addClass("secondary-nav-fixed"),e("a.trigger").css({top:"94px"}),e(".main-center-sidebar__laptop-sub").css({top:"30px"}),e(".panel ul").css({top:"44px"}),e(".template-center-menu").css({"padding-top":"0px"})):t>r&&(s.removeClass("is-hidden"),a.addClass("fixed").removeClass("slide-up"),n.addClass("secondary-nav-fixed"))}(r):function(e){d-e>i?s.removeClass("is-hidden"):e-d>i&&e>o&&s.addClass("is-hidden")}(r),d=r,t=!1}s.on("click",".nav-trigger",function(e){e.preventDefault(),s.toggleClass("nav-open")}),e(window).on("scroll",function(){t||(t=!0,window.requestAnimationFrame?requestAnimationFrame(r):setTimeout(r,250))}),e(window).on("resize",function(){s.height()})}),$(document).ready(function(){$(".template-header").hasClass("is-hidden")&&($(".template-center-menu").css({"padding-top":"75px"}),$("a.trigger").css({top:"60px"}),$(".main-center-sidebar__laptop-sub").css({top:"30px"}),$(".panel ul").css({top:"72px"}))}),$(document).ready(function(){$(".trigger").click(function(){return $(".panel").toggle("fast"),$(this).toggleClass("active"),!1})});