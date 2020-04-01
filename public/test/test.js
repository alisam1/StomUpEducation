// // получаем параметры из URL
// $.extend({
//   getUrlVars: function(){
//     var vars = [], hash;
//     var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
//     for(var i = 0; i < hashes.length; i++)
//     {
//       hash = hashes[i].split('=');
//       vars.push(hash[0]);
//       vars[hash[0]] = hash[1];
//     }
//     return vars;
//   },
//   getUrlVar: function(name){
//     return $.getUrlVars()[name];
//   }
// });
//
//
// //Достаем дату из календаря и аккуратно складываем ее в инпут
// $('.events__choise').on('click',  function(){
//   var dataCal = $('#date_calendar').DatePickerGetDate('Y-m-d');
//     $('#events_filter_date').val(dataCal);
// });
//
// //Типы мироприятий
// $('.block__events').on('click', function(){
//   var event_type_fill = $(this).data('way_id');
//
//   var already_var = $.getUrlVar('event_types');
//   if(!already_var){
//     //Если параметры есть
//     if(window.location.href.indexOf("?") > -1){
//     document.location.href='&event_types='+event_type_fill+'&';
//   } else {
//     document.location.href='?event_types='+event_type_fill+'&';
//   }
//   } else {
//      //Если параметры есть
//     var href_now = window.location.href;
//
//
//     var url = new URL(href_now);
//     var search_url = url.search;
//     var url_origin = url.origin;
//     var url_pathname = url.pathname;
//
//     var arr_par_url = search_url.split('&');
//
//     for (var i = 0; i < arr_par_url.length; i++) {
//
//       if(arr_par_url[i].indexOf('event_types') > -1){
//           if(arr_par_url[i].indexOf(event_type_fill) <= -1){
//             arr_par_url[i] += ',' + event_type_fill;
//           }
//       }
//
//     }
//
//     var search_str = arr_par_url.join('&');
//
//     var new_try_url = url_origin+url_pathname+search_str;
//
//     document.location.href = new_try_url;
//
//
//   }
//
// });
