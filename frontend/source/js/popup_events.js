// $(function () {
//
//   var form = $("#events_mega_modal");
//     form.validate({
//         errorPlacement: function errorPlacement(error, element) { element.before(error); },
//         rules: {
//             confirm: {
//                 equalTo: "#password"
//             }
//         }
//     });
//
//     form.children("div").steps({
//         headerTag: "h2",
//         bodyTag: "section",
//         transitionEffect: "fade",
//         enableFinishButton: false,
//         enableAllSteps: true,
//         autoFocus: true,
//         transitionEffectSpeed: 500,
//         onStepChanging: function (event, currentIndex, newIndex)
//           {
//             alert('rrr');
//               form.validate().settings.ignore = ":disabled,:hidden";
//               return form.valid();
//           },
//         titleTemplate: '<span class="title">#title#</span>',
//         labels: {
//             previous: 'Previous',
//             next: 'Далее',
//             finish: 'Готово',
//             current: ''
//         }
//     });
// });

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

        $('.workTypeLabel').slideToggle(300);

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
        console.log("123344");
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

    $(function () {

        $(".line_toggle").click(function(){

            $('.workLineLabel').slideToggle(300);

            return false;

        });
    });

    $(function () {

        $(".line_toggle_city").click(function(){

            $('.mainSelectCity').slideToggle(300);

            return false;

        });
    });


    $(function () {

        $(".line_toggle_lector").click(function(){

            $('.mainSelectLector').slideToggle(300);

            return false;

        });
    });

    $(".checkbox_line").click(function(){
        var val_in = [];
        // console.log("123344");
        $.each($(".checkbox_line input:checked"), function(i,n){
            val_in[i] = $(n).val();
            // console.log(val_in);
        });
        $('#my_hidden_val').val(val_in.join(','));
    });

$(function () {
    if ($(window).width() < 767) {
        $(".title").text("Шаг");
    }
});
