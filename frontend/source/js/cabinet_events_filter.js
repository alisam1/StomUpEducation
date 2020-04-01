// получаем параметры из URL расширение jQuery
$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});

//Функция записи в инпут в виде даты
function genDateInput(){
  var dataCal = $('#date_calendar').DatePickerGetDate('Y-m-d');
    $('#events_filter_date').val(dataCal);
}

//Достаем дату из календаря и аккуратно складываем ее в инпут
$('.events__choise').on('click',  function(){
  var dataCal = $('#date_calendar').DatePickerGetDate('Y-m-d');
    $('#events_filter_date').val(dataCal);
});


//Ловим клик на Применить
$('.events__apply').on('click', function(){
  //Поиск по дате
  genDateInput();
  var unparse_date = $('#events_filter_date').val();
  //разбираем полученные данные по , что бы получить массив
  var arr_date = unparse_date.split(',');

  if($('#is_calendar_touch').val() == '0'){
    arr_date[1] = '2999-01-01';
  }

  var href_now = window.location.href;
  var url = new URL(href_now);
  var search_url = url.search;
  var url_origin = url.origin;
  var url_pathname = url.pathname;


//!!!!
//Получаем данные из скрытых инпутов Направления, Города, Лектора
var hidden_inputs_filter_str = '';
//Проверяем на существование селекторы
if( $('#my_hidden_way').length > 0 ){
  //На самом деле это Type
  var fill_types = $('#my_hidden_way').val();
    if(fill_types != ''){
      hidden_inputs_filter_str = hidden_inputs_filter_str + '&type='+fill_types;
    }

}
if( $('#my_hidden_lectors').length > 0 ){
  var fill_lectors = $('#my_hidden_lectors').val();
    if (fill_lectors != '') {
        hidden_inputs_filter_str = hidden_inputs_filter_str + '&lectors='+fill_lectors;
    }
}
if( $('#workCityTags').length > 0 ){
  var fill_citys = $('#workCityTags').val();
    if(fill_citys != ''){
      hidden_inputs_filter_str = hidden_inputs_filter_str + '&citys='+fill_citys;
    }
}

//!!!!


  if(search_url.indexOf('date_from') <= -1){
  //Если параметры есть
  if(window.location.href.indexOf("?") > -1){
  var add_q_str ='date_from='+arr_date[0]+'&date_to='+arr_date[1]+'&';
    var full_q_str = url_origin+url_pathname+search_url+add_q_str;
  } else {
  var add_q_str ='?fill&date_from='+arr_date[0]+'&date_to='+arr_date[1]+'&';
  var full_q_str = url_origin+url_pathname+add_q_str;
  }
  //Поиск по дате

  //Поиск по диапазону цены
  //Если только бесплатные чекнут
  if( $('#checkbox__agree').prop("checked") ){
    var full_q_str = full_q_str+'is_free=1&';
  } else {
    var data_price_min = parseInt($('.events__polz #min').val());
    var data_price_max = parseInt($('.events__polz #max').val());

    full_q_str = full_q_str + 'price_from='+data_price_min+'&price_to='+data_price_max+'&'+hidden_inputs_filter_str+'&';

  }
  //Поиск по диапазону цены

  document.location.href = full_q_str;

} else {


  var add_q_str ='?fill&date_from='+arr_date[0]+'&date_to='+arr_date[1]+'&';
  var full_q_str = url_origin+url_pathname+add_q_str;

  //Поиск по диапазону цены
  //Если только бесплатные чекнут
  if( $('#checkbox__agree').prop("checked") ){
    var full_q_str = full_q_str+'is_free=1&';
  } else {
    var data_price_min = parseInt($('.events__polz #min').val());
    var data_price_max = parseInt($('.events__polz #max').val());

    full_q_str = full_q_str + 'price_from='+data_price_min+'&price_to='+data_price_max+'&'+hidden_inputs_filter_str+'&';

  }
  //Поиск по диапазону цены

  document.location.href = full_q_str;


}

});

//Типы мироприятий
$('.block__events').on('click', function(){
  var event_type_fill = $(this).data('way_id');

      var href_now = window.location.href;
      var url = new URL(href_now);
      var search_url = url.search;
      var url_origin = url.origin;
      var url_pathname = url.pathname;

  var already_var = $.getUrlVar('event_ways');
  if(!already_var){

    //Если event_ways есть
    if(window.location.href.indexOf("?") > -1){
    search_str='event_ways='+event_type_fill+'&';
    var new_try_url = url_origin+url_pathname+search_url+search_str;
  } else {
    search_str='?fill&event_ways='+event_type_fill+'&';
    var new_try_url = url_origin+url_pathname+search_str;
  }


  document.location.href = new_try_url;


  } else {
     //Если event_ways нет
    var arr_par_url = search_url.split('&');

    for (var i = 0; i < arr_par_url.length; i++) {

      if(arr_par_url[i].indexOf('event_ways') > -1){
          if(arr_par_url[i].indexOf(event_type_fill) <= -1){
            arr_par_url[i] += ',' + event_type_fill;
          } else {
            arr_par_url[i] = arr_par_url[i].replace(','+event_type_fill,'');
          }

      }

    }

    var search_str = arr_par_url.join('&');

      var new_try_url = url_origin+url_pathname+search_str;


    document.location.href = new_try_url;


  }

});

$('.events__clear').on('click', function(){

  var href_now = window.location.href;
  var url = new URL(href_now);
  var search_url = url.search;
  var url_origin = url.origin;
  var url_pathname = url.pathname;

  if(search_url != ''){
    document.location.href = url_origin+url_pathname;
  }

});

/* New clear lectors inputs  */

$(".checkselect_lectors").click(function(){
  var val_in = [];
  // console.log("123344");
  $.each($(".checkselect_lectors input:checked"), function(i,n){
      val_in[i] = $(n).val();
      console.log(val_in);
  });
  $('#lectors_hidden_cabinet').val(val_in.join(','));
});


/* New clear events inputs  */

$(".checkselect_event").click(function(){
  var val_in = [];
  // console.log("123344");
  $.each($(".checkselect_event input:checked"), function(i,n){
      val_in[i] = $(n).val();
      // console.log(val_in);
  });
  $('#events_hidden').val(val_in.join(','));
});


/* Subdomain events filtres - lectors  */

$(".checkselect-sub_lectors").click(function () {
  var val_in = [];
  // console.log("123344");
  $.each($(".checkselect-sub_lectors input:checked"), function (i, n) {
    val_in[i] = $(n).val();
    console.log(val_in);
  });
  $('#lectors_hidden_sub').val(val_in.join(','));
});


/*Subdomain events filtres - events  */

$(".checkselect-sub_events").click(function () {
  var val_in = [];
  // console.log("123344");
  $.each($(".checkselect-sub_events input:checked"), function (i, n) {
    val_in[i] = $(n).val();
    // console.log(val_in);
  });
  $('#events_hidden_sub').val(val_in.join(','));
});