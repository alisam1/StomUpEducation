    $(function () {
        /* Скрытие блока создания лектора */
        $('.ilya_createEvent_createLector').hide();
        
        
        /*  Клик по кнопке добавить лектора */
        $('.ilya_buttonAddLector').on('click', (e) => {
            /* Скрытие списка лекторов и кнопки "далее" */
            $('.ilya_createEvent_lectorsList').hide();
            $(".wizard-form li a[href='#next']").parent().hide();
            
            /* Показ блока создания лектора */
            $('.ilya_createEvent_createLector').show();
        });
        
        
        /*Клик по кнопке сохранить нового лектора*/
        $('.ilya_buttonAddNewLector').on('click', (e) => {
            
            /* Сбор значений из инпутов */
            let lastName = $(".ilya_createEvent_createLector input[name='lastName']").val(); /* Фамилия */
            let firstName = $(".ilya_createEvent_createLector input[name='firstName']").val(); /* Имя */
            let middleName = $(".ilya_createEvent_createLector input[name='middleName']").val(); /* Отчество */

            let new_lector_photo = null; /* Фото лектора */
            let full_name = lastName + " " + firstName + " " + middleName; /* Полное имя */
            let worker_position = $(".ilya_createEvent_createLector input[name='position']").val(); /* Должность */
            let lector_phone = $(".ilya_createEvent_createLector input[name='phoneNumber']").val(); /* Номер телефона */
            let lector_email = $(".ilya_createEvent_createLector input[name='email']").val(); /* Email */
            
            console.log("Here");
            postNewLector(new_lector_photo, full_name, worker_position, lector_phone, lector_email);
            
            /* Скрытие блока создания лектора*/
            $('.ilya_createEvent_createLector').hide();
            
            /* Показ списка лекторов и кнопки "далее" */
            $(".wizard-form li a[href='#next']").parent().show();
            $('.ilya_createEvent_lectorsList').show();
        });
        
        
        
        
        
        
        
        $('.steps .clearfix').css("margin-left", 0);
        
    });

function postNewLector(new_lector_photo, full_name, worker_position, lector_phone, lector_email) {
    console.log("HereHere");
    
    /*let data = {};
    data["new_lector_photo"] = new_lector_photo;
    data["full_name"] = full_name;
    data["worker_position"] = worker_position;
    data["lector_phone"] = lector_phone;
    data["lector_email"] = lector_email;*/
    
    /*console.log(data);
    console.log(JSON.stringify(data));
    console.log(JSON.parse(JSON.stringify(data)));*/
    
    /*return fetch ('/catch/catch_lector/callback', {
        method: "POST",
        headers: {
            'Content-Type': "application/json",
        },
        body: JSON.stringify(data),
    })
    .then(response => JSON.parse(response));*/
    
    return $.post(
        '/catch/catch_lector/callback', 
        {
            new_lector_photo:new_lector_photo,
            full_name:full_name,
            worker_position:worker_position,
            lector_phone:lector_phone,
            lector_email:lector_email,
        },
        (data) => {
            console.log(data);
            $('.ilya_createEvent_lectorsList').append(`
              <div class="events__block">
                    <input name="lectors" type="checkbox" value="${data.id}" checked="true">
                    <div class="events__photo"><img src="${data.photo}" alt="ev_photo"></div>
                    <div class="events__block-mobile">
                        <div class="events__fio">${data.full_name}</div>
                        <div class="events__work">${data.worker_position}</div>
                    </div>
                    <div class="events__lectures">10</div>
                    <div class="events__phone"><a href="">${data.phone}</a></div>
                    <div class="events__mail"><a href="">${data.email}</a></div>
                </div>
            `);
            
            /* Установка id */
            $('#my_hidden_lectors').val(data.id);
            
            /* Очистка полей */
            $(".ilya_createEvent_createLector input[name='lastName']").val = ""; /* Фамилия */
            $(".ilya_createEvent_createLector input[name='firstName']").val = ""; /* Имя */
            $(".ilya_createEvent_createLector input[name='middleName']").val = ""; /* Отчество */

            //let new_lector_photo = null; /* Фото лектора */
            let full_name = ""; /* Полное имя */
            $(".ilya_createEvent_createLector input[name='position']").val = ""; /* Должность */
            $(".ilya_createEvent_createLector input[name='phoneNumber']").val = ""; /* Номер телефона */
            $(".ilya_createEvent_createLector input[name='email']").val = ""; /* Email */
        });
}




