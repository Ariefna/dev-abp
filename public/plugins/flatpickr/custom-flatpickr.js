// Flatpickr

var f1 = flatpickr(document.getElementById('basicFlatpickr'), {
    defaultDate: new Date()
});
var f5 = flatpickr(document.getElementById('td'), {
    defaultDate: new Date()
});
var f6 = flatpickr(document.getElementById('td_jkt'), {
    defaultDate: new Date()
});
var f7 = flatpickr(document.getElementById('eta'), {
    defaultDate: new Date()
});
var f10 = flatpickr(document.getElementById('tiba'), {
    defaultDate: new Date()
});
var f2 = flatpickr(document.getElementById('dateTimeFlatpickr'), {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    defaultDate: new Date()
});
var f3 = flatpickr(document.getElementById('rangeCalendarFlatpickr'), {
    mode: "range",
});
var f4 = flatpickr(document.getElementById('timeFlatpickr'), {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    defaultDate: "13:45",
});