/**
 * Reservation form.
 *
 * @param $ jQuery
 */
var reservationform = function($) {

    if ($("#date").length > 0) {
        $("#date").pickadate({
            format: "dd/mm/yyyy",
            min: "0",
            onSet: function (context) {
                loadBookedTimes(new Date(context.select));
            }
        });
    }

    if ($("#time").length > 0) {
        $("#time").pickatime({
            format: "HH:i",
            interval: 15
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

    var $input = $('#time').pickatime();
    var picker = $input.pickatime('picker');

    picker.set('disable', false);

    if (selectedDate in booked) {
        var dates = [];
        $.each(booked[selectedDate], function() {
            dates.push(this.split(':'));
        });
        picker.set('disable', dates);
    }
}

jQuery(document).ready(reservationform);
