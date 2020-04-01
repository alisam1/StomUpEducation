$(document).ready(function(){

$.post('/api/count/eventsways', function(data){

    for(key in data){
      $('#'+key+'').text(data[key]);
    }

});

});
