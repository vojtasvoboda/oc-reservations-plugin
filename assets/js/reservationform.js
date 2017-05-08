/**
 * Reservation form.
 *
 * @param $ jQuery
 */
var reservationform = function($) {

    if ($("#date").length > 0) {
        $("#date").pickadate({
            format: dateFormat,
            min: "0",
            disable: disableDays,
            firstDay: firstDay,
            onSet: function (context) {
                loadBookedTimes(new Date(context.select));
            }
        });
    }

    if ($("#time").length > 0) {
        $("#time").pickatime({
            format: timeFormat,
            min: startWork,
            max: finishWork,
            interval: timeInterval
        });

        disableAllTimes();
    }
};

/**
 * Disable all timepicker dates.
 */
function disableAllTimes()
{
    var $input = $("#time").pickatime();
    var picker = $input.pickatime("picker");
    picker.set("disable", [{
        from: [0, 0],
        to: [23, 45]
    }]);
}

/**
 * Load booked times for given date and disable them in timepicker.
 *
 * @param date
 */
function loadBookedTimes(date)
{
    var day = (date.getDate() < 10 ? '0' : '') + date.getDate();
    var month = date.getMonth() + 1;
    month = (month < 10 ? '0' : '') + month;
    var selectedDate = day + '/' + month + '/' + date.getFullYear();

    var dateNow = new Date();
    var dateNowFormat = (dateNow.getDate() < 10 ? '0' : '') + dateNow.getDate();
    dateNowFormat += '/' + (dateNow.getMonth() < 9 ? '0' : '') + (dateNow.getMonth() + 1);
    dateNowFormat += '/' + date.getFullYear();

    var $input = $('#time').pickatime();
    var picker = $input.pickatime('picker');

    picker.set('disable', false);
    var dates = [];

    if (dateNowFormat == selectedDate) {
        dates.push({
            from: [0, 0],
            to: [dateNow.getHours(), Math.floor(dateNow.getMinutes() / timeInterval) * timeInterval]
        });
    }

    if (selectedDate in booked) {
        $.each(booked[selectedDate], function() {
            dates.push(this.split(':'));
        });
    }

    picker.set('disable', dates);
}

jQuery(document).ready(reservationform);
