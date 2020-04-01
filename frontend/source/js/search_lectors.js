/*

$(function(){

    $('.hint_lector_name').bind("change keyup input click", function() {
        if(this.value.length >= 2){
            $.ajax({
                type: 'post',
                url: " /hint/lector", //Путь к обработчику
                dаta: {'lector':  this.value},
                response: 'text',
                success: function(data){
                        var search_lector = $('.hint_lector_name').val();
                        var fileList = data.filter(function(item) {
                        return item.full_name.indexOf(search_lector) > -1
                      })

                      if(fileList.length !== 0){
                        for ( var i=0; i<fileList.length; ++i){
                                $('.search_result').each(function () {	
                               $(this). html('<li class="search_lector">' + fileList[i].full_name + '</li>').fadeIn();
                                });
                            } 
                        }
               }
           })
        }
    })

        
    $(".search_result").hover(function(){
        $(".hint_lector_name").blur(); //Убираем фокус с input
    })

    //При выборе результата поиска, прячем список и заносим выбранный результат в input
    $(".search_result").on("click", "li", function(){
      
        s_user = $(this).text();
        $(".hint_lector_name").val(s_user);
        $(".search_result").fadeOut();
    })
    })

    */
