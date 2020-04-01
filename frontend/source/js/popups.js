/* Popup gallery */

$(document).ready(function () {
  $('.popup-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: 'Loading image #%curr%...',
    mainClass: 'mfp-img-mobile',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
    },
    image: {
      tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
      titleSrc: function (item) {
        return item.el.attr('title');
      }
    }
  });
});


/* Lectures modal */

$(document).ready(function(){
  $('.spoiler_links').click(function(){
   $(this).parent().children('div.spoiler_body').toggle('normal');
   return false;
  });
 });


//Popup Events
$(function () {

    var form = $("#events_mega_modal");
      form.validate({
          errorPlacement: function errorPlacement(error, element) { element.before(error); },
          rules: {

            events_name: {
              required: true,
              minlength: 2
            },
            tags: {
              required: true,
            },
            ways: {
              required: true,
            },
            events_city: {
              required: true,
              minlength: 3
            },
            events_address: {
              required: true,
              minlength: 3
            },
            my_hidden_lectors:{
              required: true,
              minlength: 1
            }

          },
          messages: {

            events_name: {
              required: "Поле 'Название' обязательно к заполнению",
              minlength: "Введите не менее 2-х символов в поле 'Название'"
            },
            tags: {
              required: "Поле 'Вид мероприятия' обязательно к заполнению",
            },
            ways: {
              required: "Поле 'Направление' обязательно к заполнению",
            },
            events_city: {
              required: "Поле 'Город' обязательно к заполнению",
              minlength: "Введите не менее 3-х символов в поле 'Город'"
            },
            events_address: {
              required: "Поле 'Адрес' обязательно к заполнению",
              minlength: "Введите не менее 3-х символов в поле 'Адрес'"
            },
            my_hidden_lectors: {
              required: "К мероприятию должен быть прикреплен хотя бы один лектор",
              minlength: "К мероприятию должен быть прикреплен хотя бы один лектор"
            },



          }
      });

    form.children("div").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        enableFinishButton: false,
        enableAllSteps: true,
        autoFocus: true,
        transitionEffectSpeed: 500,
        titleTemplate: '<span class="title">#title#</span>',
                onStepChanging: function (event, currentIndex, newIndex)
                  {

                    if(currentIndex == 1){
                      if($('#data-start').val() == '' || $('#data-finish').val() == '' || $('#time-start').val() == '' || $('#time-finish').val() == '' ){
                        Swal.fire({
                        icon: 'warning',
                        title: 'Упс!',
                        text: 'Дата начала и окончания должна быть заполненна полностью',
                        });

                        return false;
                      }
                    }

                    if(currentIndex == 1){
                      var getStartDate = $('#data-start').val();
                      var getStartTime = $('#time-start').val();
                      var getStartDateArr = getStartDate.split('.');
                      var getRightStartDate = getStartDateArr[2]+'-'+getStartDateArr[1]+'-'+getStartDateArr[0]+'T'+getStartTime+':00';

                      if( new Date(getRightStartDate) < new Date() ){
                        Swal.fire({
                        icon: 'warning',
                        title: 'Упс!',
                        text: 'Дата начала не может быть раньше текущей даты и времени',
                        });

                        return false;
                      }
                    }
                    if(currentIndex == 2){
                      var editor1 = CKEDITOR.replace('editor1',{height: 270});
                      if($('#my_hidden_lectors').val() == ''){
                        Swal.fire({
                        icon: 'warning',
                        title: 'Упс!',
                        text: 'Хотя бы один лектор - должен быть выбран',
                        });

                        return false;
                      }
                    }
                    if(currentIndex == 3){
                      let textAreaData = CKEDITOR.instances.editor1.getData();
                      $('#editor1').html(textAreaData);
                    }
                    // console.log(currentIndex);
                      form.validate();
                      return form.valid();
                  },
        labels: {
            previous: 'Previous',
            next: 'Далее',
            finish: 'Готово',
            current: ''
        },
        onInit: function (event, currentIndex) {
          $('#data-start').inputmask("99.99.9999");
          $('#data-finish').inputmask("99.99.9999");
          $('#time-start').inputmask("99:99");
          $('#time-finish').inputmask("99:99");
        }
    });
});

$(function () {
var values = [];

$("#workType label").on("click", function(){
        var input = $(this).children("input");
        var tag = $(this).text();
        var i = values.indexOf(tag);
        if (input.prop("checked"))  {
            input.parent().addClass("selected");
            if (i==-1) values.push(tag);
        } else {
            if (i>-1) values.splice(i, 1);
            input.parent().removeClass("selected");
        }
        $("#workTypeTags").val(values.join(", "));
    });
});

$(function () {

    $(".type_toggle").click(function(){

        $('.workTypeLabel').slideToggle(100);

        return false;

    });
});

$(function () {

    var limit = 1;
        $('.selected input.workTypeCheck').on('change', function(evt) {
        if($(this).siblings(':checked').length >= limit) {
            this.checked = false;
        }
    });
});

$(function () {
    var values = [];

    $("#workLine label").on("click", function(){
            var input = $(this).children("input");
            var tag = $(this).text();
            var i = values.indexOf(tag);
            if (input.prop("checked"))  {
                input.parent().addClass("selected");
                if (i==-1) values.push(tag);
                //alert(tag);
            } else {
                if (i>-1) values.splice(i, 1);
                input.parent().removeClass("selected");
            }
            $("#workLineTags").val(values.join(", "));
        });
    });

    $(function() {
      $('.line_toggle').click(function(event) {
          $('.workLineLabel').slideToggle(300);
           console.log('122')
      });
      $(document).click(function (event) {
          if ($(event.target).closest('.workLineLabel').length == 0 && $(event.target).attr('class') != 'line_toggle') {
              $('.workLineLabel').hide();
          }
      });
  });
  $(function() {
    $('.line_toggle_city').click(function(event) {
        $('.mainSelectCity').slideToggle(300);
        // console.log('122')
    });
    $(document).click(function (event) {
        if ($(event.target).closest('.mainSelectCity').length == 0 && $(event.target).attr('class') != 'line_toggle_city') {
            $('.mainSelectCity').hide();
        }
    });
});

    $(function() {
      $('.line_toggle_lector').click(function(event) {
          $('.mainSelectLector').slideToggle(300);
          // console.log('122')
      });
      $(document).click(function (event) {
          if ($(event.target).closest('.mainSelectLector').length == 0 && $(event.target).attr('class') != 'line_toggle_lector') {
              $('.mainSelectLector').hide();
          }
      });
  });


    $(function () {

    $(".checkbox_line").click(function(){
        var val_in = [];
        // console.log("123344");
        $.each($(".checkbox_line:checked"), function(i,n){
            val_in[i] = $(n).val();
            // console.log(val_in);
        });
        $('#my_hidden_val').val(val_in.join(','));
    });
});

/* Lectors json */

$(function () {

    $(".events__block").click(function(){
        var val_in = [];
        $.each($(".events__block input[type='checkbox']:checked"), function(i,n){
            val_in[i] = $(n).val();
            // console.log(val_in);
        });
        $('#my_hidden_lectors').val(val_in.join(', '));
    });
});

/* Way main json */

$(function () {

  $(".main-select__type").click(function(){
      var val_in = [];
      $.each($(".main-select__type input[type='checkbox']:checked"), function(i,n){
          val_in[i] = $(n).val();
          // console.log(val_in);
      });
      $('#my_hidden_way').val(val_in.join(', '));
  });
});

/* Lectors main json */

$(function () {

  $(".main-select__lector").click(function(){
      var val_in = [];
      $.each($(".main-select__lector input[type='checkbox']:checked"), function(i,n){
          val_in[i] = $(n).val();
          // console.log(val_in);
      });
      $('#my_hidden_lectors').val(val_in.join(', '));
  });
});

/* City main json */

$(function () {

  $(".main-select__city").click(function(){
      var val_in = [];
      $.each($(".main-select__lector input[type='checkbox']:checked"), function(i,n){
          val_in[i] = $(n).val();
          // console.log(val_in);
      });
      $('#my_hidden_city').val(val_in.join(', '));
  });
});

$(function () {
    if ($(window).width() < 767) {
        $(".title").text("Шаг");
    }
});
//-----------
