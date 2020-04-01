$(function() {


    /* Main select type */

    var values = [];

    $("#workDesign label").on("click", function(){
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
        $("#workDesignTags").val(values.join(", "));
    });


        $(".content_toggle").click(function(){

            $('.mainSelectType').slideToggle(300);      
        
            return false;
        
        });

        /* Main select city */

        var valuesCity = [];
    
        $("#workCity label").on("click", function(){
                var input = $(this).children("input");
                var tag = $(this).text();
                var i = valuesCity.indexOf(tag);
                if (input.prop("checked"))  {
                    input.parent().addClass("selected");
                    if (i==-1) valuesCity.push(tag);
                    //alert(tag);
                } else {
                    if (i>-1) valuesCity.splice(i, 1);
                    input.parent().removeClass("selected");
                }
                $("#workCityTags").val(valuesCity.join(", "));
            });
    
    
            $(".content_city").click(function(){
    
                $('.mainSelectCity').slideToggle(300);      
            
                return false;
            
            });


        /* Main select lectors */
        var valuesLector = [];
    
        $("#workLector label").on("click", function(){
                var input = $(this).children("input");
                var tag = $(this).text();
                var i = valuesLector.indexOf(tag);
                if (input.prop("checked"))  {
                    input.parent().addClass("selected");
                    if (i==-1) valuesLector.push(tag);
                    //alert(tag);
                } else {
                    if (i>-1) valuesLector.splice(i, 1);
                    input.parent().removeClass("selected");
                }
                $("#workLectorTags").val(valuesLector.join(", "));
            });
    
    
            $(".content_lector").click(function(){
    
                $('.mainSelectLector').slideToggle(300);      
            
                return false;
            
            });
});


$('.main-lector-center__bottom').readmore({
    speed: 250, 
    maxHeight: 200, 
    heightMargin: 16,  
    moreLink: '<a href="#" class = "main-lector-center__bottom-link">Подробно</a>', 
    lessLink: '<a href="#" class = "main-lector-center__bottom-link">Свернуть</a>', 
});

  $(document).ready(function(){
    $(".sidebar_button").click(function(){
        $(".sidebar_content").slideToggle("slow");
        return false;
    });
});