function datepicker_format(format) {
    var assoc = {
        'Y': 'yyyy',
        'y': 'yy',
        'F': 'MM',
        'm': 'mm',
        'l': 'DD',
        'd': 'dd',
        'D': 'D',
        'j': 'd',
        'M': 'M',
        'n': 'm',
        'z': 'o',
        'N': '',
        'S': '',
        'w': '',
        'W': '',
        't': '',
        'L': '',
        'o': '',
        'a': 'a',
        'A': 'A',
        'B': '',
        'g': 'h',
        'G': 'H',
        'h': 'hh',
        'H': 'HH',
        'i': 'i',
        's': '',
        'u': ''
    };

    for (var key in assoc) {
        format = format.replace(new RegExp(key, "g"), '\{\{' + key + '\}\}');
    }

    for (var index in assoc) {
        format = format.replace(new RegExp('\{\{' + index + '\}\}', "g"), assoc[index]);
    }

    return format.replace(/(^:)|(:$)/g, "");
}

function get_work_days(days, weekStartMonday) {
    var work_days = [true];
    var week_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

    if (weekStartMonday) {
        week_days.push('sunday');
    } else {
        week_days.unshift('sunday');
    }

    for (var index in week_days) {
        if (days.indexOf(week_days[index]) >= 0) {
            work_days.push(index - 0 + 1);
        }
    }

    return work_days;
}

function convertTimeToArray(time) {
    var timeArray = time.split(':');

    if (timeArray.length < 2) {
        timeArray.push(0);
    }

    return timeArray;
}

// If we're running under the Node (Mocha testing)
if (typeof exports !== 'undefined') {
    exports.datepicker_format = datepicker_format;
    exports.get_work_days = get_work_days;
    exports.convertTimeToArray = convertTimeToArray;
}
