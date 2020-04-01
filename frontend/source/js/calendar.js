// https://www.eyecon.ro/datepicker/#implement
//Получение выбранного диапазона
// $('#date_calendar').DatePickerGetDate('Y-m-d');
var realdate = $('#realDate').val();
$('#date_calendar').DatePicker({
flat: true,
date: [realdate,realdate],
current: realdate,
calendars: 1,
mode: 'range',
starts: 1,
locale: {
days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
daysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
next: '<span class="right_arrow_calendar"></span>',
prev: '<span class="left_arrow_calendar"></span>',
}
});