//API для поиска лекторов по введенным символам
$('.hint_lector_name').change(function(){
  alert('test');
});

//Апи для подсчета количеств в левом меню
$(document).ready(function(){
  $.post('/hint/count_data', function(data){
    $('.lector_counter').text(data.lectors_count);
    $('.event_counte').text(data.events_count);
  });
});
