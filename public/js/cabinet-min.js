var accordion=function(){var o=$(".js-accordion").find(".js-accordion-header"),n=($(".js-accordion-item"),{speed:400,oneOpen:!1});return{init:function(e){o.on("click",function(){accordion.toggle($(this))}),$.extend(n,e),n.oneOpen&&$(".js-accordion-item.active").length>1&&$(".js-accordion-item.active:not(:first)").removeClass("active"),$(".js-accordion-item.active").find("> .js-accordion-body").show()},toggle:function(o){n.oneOpen&&o[0]!=o.closest(".js-accordion").find("> .js-accordion-item.active > .js-accordion-header")[0]&&o.closest(".js-accordion").find("> .js-accordion-item").removeClass("active").find(".js-accordion-body").slideUp(),o.closest(".js-accordion-item").toggleClass("active"),o.next().stop().slideToggle(n.speed)}}}();$(document).ready(function(){accordion.init({speed:300,oneOpen:!0})}),$(function(){jGroup=$(".group"),jContent=$(".content"),jGroup.on("click",function(o){jThis=$(o.currentTarget),jGroup.removeClass("opened"),jContent.find(".main-container").removeClass("opened"),jThis.addClass("opened"),jThis.hasClass("a")&&jContent.find(".bottom-events").addClass("opened"),jThis.hasClass("b")&&jContent.find(".bottom-banners").addClass("opened"),jThis.hasClass("c")&&jContent.find(".bottom-app").addClass("opened")})}),$(function(){$(".popup-modal").magnificPopup({type:"inline",preloader:!1,focus:"#username",modal:!0}),$(document).on("click",".popup-modal-dismiss",function(o){o.preventDefault(),$.magnificPopup.close()})});