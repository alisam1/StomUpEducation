$(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#web-banner').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#create-banner").change(function(){
        readURL(this);
    });
});


$(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#web-banner').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#create-banner").change(function(){
        readURL(this);
    });
});

$(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#about-sitelogo').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#create-logo").change(function(){
        readURL(this);
    });
});

$(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#listener-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#listener-photo").change(function () {
        readURL(this);
    });
});

$(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#about-cover').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#cover-photo").change(function(){
        readURL(this);
    });
});

$(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#lectures-new').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#lectures-photo").change(function(){
        readURL(this);
    });
});

$(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#edit-lector').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#new_edit_photo").change(function () {
        readURL(this);
    });
});

$(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#new-photo-lector').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#new_lector_photo").change(function () {
        readURL(this);
    });
});

$(function () {
    $(function imgError(image) {
            image.onerror = "";
            image.src = "/img/logo.png";
            return true;
    });
});

$(function () {
    function testHover (target, changeTarget, classX){
        $(target)
        .mouseenter(function(){
          $(changeTarget).addClass(classX);
        })
        .mouseleave(function(){                 
            $(changeTarget).removeClass(classX);
        });
      
      };
      testHover(".web__name",".web-right__one", "web-right__one-hover");
      testHover(".web__create-header",".web-right__two", "web-right__two-hover");
      testHover(".web__create-banner",".web-right__three", "web-right__three-hover");
      testHover(".web__create__events",".web-right__four", "web-right__four-hover");
      testHover(".web__create__lectures",".web-right__five", "web-right__five-hover");
      testHover(".web__create__reviews",".web-right__six", "web-right__six-hover");
      testHover(".web__create__address",".web-right__seven", "web-right__seven-hover");
      testHover(".web__create__about",".web-right__eight", "web-right__eight-hover");
      testHover(".web__create-footer",".web-right__nine", "web-right__nine-hover");
      
});


$("#move_to_banners").on("click", function(){

    window.location = "/cabinet/site/banners";

});

$(function () {
$( ".details" ).focus(function() {
    $("#item_one" ).css( "background-color", "red" ).fadeOut( 1000 );
  });
});