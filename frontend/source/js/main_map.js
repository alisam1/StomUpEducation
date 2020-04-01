$('.main-map__content-bottom__card').on('click', function(){
  $('.main-map__content-bottom__card').removeClass('active');
  $(this).addClass('active');

  var mapCord = $(this).attr('data-cord');

  mapCord = mapCord.split(',');

  // console.log(mapCord);
  map.remove();
  // var map;
  DG.then(function () {
      map = DG.map( 'map', {
          center: mapCord,
          zoom: 15,
          scrollWheelZoom: false,
      });
      DG.marker(mapCord).addTo(map);
  });
});
