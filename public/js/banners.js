  $("#inputsForm input[type=checkbox]").change(function() {
    if($(this).prop("checked") == true) {
        $("#inputsForm input[type=text]").val("Записаться");
    } else {
        $("#inputsForm input[type=text]").val("");
    }
});
