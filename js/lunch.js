$(document).ready(function(){
    $('.time-start, .time-end').timepicker({
        showPeriodLabels: false,
        hourText: 'Часы',
        minuteText: 'Минуты'
    });


    $('.time-start').change(setTimeStartTotal);
    setTimeStartTotal();


    $('.time-end').change(setTimeEndTotal);
    setTimeEndTotal();

    //Изменять цвет имени юзера в зависимости от его решения
    $('input[id^=vote-]').click(function() {

        var elemId = $(this).attr('id');
        var nameField = $(this).parent().siblings()[0];

        //Проверка по какому элементу кликнули
        if (elemId.indexOf('vote-yes') != -1) {
            $(nameField).css('color', 'red');
        } else if (elemId.indexOf('vote-no') != -1) {
            $(nameField).css('color', 'gray');
        } else {
            $(nameField).css('color', 'black');
        }
    });
});

/*
 * Подсчитывать наибольшее время, начиная с которого все согласны идти
 */
function setTimeStartTotal() {

    var maxStartTime = '';

    $('.time-start').each(function(){
        if ($(this).val() && $(this).val() > maxStartTime) {
            maxStartTime = $(this).val();
        }
    });

    //Значение, когда все поля пустые
    if (maxStartTime == '') {
        maxStartTime = '...';
    }

    $('#time-start-total').html(maxStartTime);
}

/*
 * Подсчитывать наименьшее время, раньше которого все согласны идти
 */
function setTimeEndTotal() {

    var maxEndTime = '23:59';

    $('.time-end').each(function(){
        if ($(this).val()) {
            if ($(this).val() < maxEndTime) {
                maxEndTime = $(this).val();
            }
        }
    });

    //Значение, когда все поля пустые
    if (maxEndTime == '23:59') {
        maxEndTime = '...';
    }

    $('#time-end-total').html(maxEndTime);
}