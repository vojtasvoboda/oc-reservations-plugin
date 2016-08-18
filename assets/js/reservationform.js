var reservationform = function($) {

    $('#date').pickadate({
        format: 'dd/mm/yyyy',
        min: '0',
        onSet: function(context) {
            loadBookedTimes(new Date(context.select));
        }
    });

    $('#time').pickatime({
        format: 'HH:i',
        interval: 15
    });

    disableAllTimes();
};

function disableAllTimes()
{
    var $input = $('#time').pickatime();
    var picker = $input.pickatime('picker');
    picker.set('disable', [{
        from: [0, 0],
        to: [23, 45]
    }]);
}

function loadBookedTimes(date)
{
    var month = date.getMonth() < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1);
    var selectedDate = date.getDate() + '/' + month + '/' + date.getFullYear();

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
