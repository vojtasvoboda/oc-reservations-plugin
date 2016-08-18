var reservationform = function($) {

    $('#date').pickadate({
        format: 'dd/mm/yyyy',
        min: '0'
    });

    $('#time').pickatime({
        format: 'HH:i',
        interval: 15
    });
};

jQuery(document).ready(reservationform);
