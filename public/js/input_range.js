/* Input range */

$(function () {
  $("#slider-range").slider({
    range: true,
    min: 0,
    max: 100000,
    values: [0, 100000],
    slide: function (event, ui) {
      $("#min").val(ui.values[0] + "₽") + " " + $("#max").val(ui.values[1] + "₽");
    }
  });
  $("#min").val($("#slider-range").slider("values", 0) + "₽") + " " + $("#max").val($("#slider-range").slider("values", 1) +
    "₽");
});


/* Input mobile range */

$(function () {
  $("#slider-range__mobile").slider({
    range: true,
    min: 0,
    max: 100000,
    values: [0, 100000],
    slide: function (event, ui) {
      $("#min__mobile").val(ui.values[0] + "₽") + " " + $("#max__mobile").val(ui.values[1] + "₽");
    }
  });
  $("#min__mobile").val($("#slider-range__mobile").slider("values", 0) + "₽") + " " + $("#max__mobile").val($("#slider-range__mobile").slider("values", 1) +
    "₽");
});

/* Input bottom range */

$(function () {
  $("#slider-range__bottom").slider({
    range: true,
    min: 0,
    max: 100000,
    values: [0, 100000],
    slide: function (event, ui) {
      $("#min__bottom").val(ui.values[0] + "₽") + " " + $("#max__bottom").val(ui.values[1] + "₽");
    }
  });
  $("#min__bottom").val($("#slider-range__bottom").slider("values", 0) + "₽") + " " + $("#max__bottom").val($("#slider-range__bottom").slider("values", 1) +
    "₽");
});

/* Input bottom range */

$(function () {
  $("#slider-range__modal").slider({
    range: true,
    min: 0,
    max: 100000,
    values: [0, 100000],
    slide: function (event, ui) {
      $("#min__modal").val(ui.values[0] + "₽") + " " + $("#max__modal").val(ui.values[1] + "₽");
    }
  });
  $("#min__modal").val($("#slider-range__modal").slider("values", 0) + "₽") + " " + $("#max__modal").val($("#slider-range__modal").slider("values", 1) +
    "₽");
});


$(function () {
  $("#slider-range__events").slider({
    range: true,
    min: 0,
    max: 100000,
    values: [0, 100000],
    slide: function (event, ui) {
      $("#min__events").val(ui.values[0] + "₽") + " " + $("#max__events").val(ui.values[1] + "₽");
    }
  });
  $("#min__events").val($("#slider-range__events").slider("values", 0) + "₽") + " " + $("#max__events").val($("#slider-range__events").slider("values", 1) +
    "₽");
});


$(function () {
  $("#slider-range__events-mobile").slider({
    range: true,
    min: 0,
    max: 100000,
    values: [0, 100000],
    slide: function (event, ui) {
      $("#min__events-mobile").val(ui.values[0] + "₽") + " " + $("#max__events-mobile").val(ui.values[1] + "₽");
    }
  });
  $("#min__events-mobile").val($("#slider-range__events-mobile").slider("values", 0) + "₽") + " " + $("#max__events-mobile").val($("#slider-range__events-mobile").slider("values", 1) +
    "₽");
});

