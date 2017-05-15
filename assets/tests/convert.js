var assert = require('assert');

var convert = require('../js/convert.js');

describe('convert', function() {
    describe('datePickerFormatTest', function() {
        it('should return dd.mm.yyyy for date format d.m.Y', function() {
            assert.equal(convert.datepicker_format('d.m.Y'), 'dd.mm.yyyy');
        });
        it('should return HH:i for time format H:i:s', function() {
            assert.equal(convert.datepicker_format('H:i:s'), 'HH:i');
        });
        it('should remove trailing comma', function() {
            assert.equal(convert.datepicker_format('H:i:'), 'HH:i');
        });
    });
    describe('getWorkDaysTest', function () {
        it('should return datepicker days format', function() {
            var days = ['monday', 'tuesday', 'wednesday'];
            var result = convert.get_work_days(days, false);
            var expectation = [true, 2, 3, 4];
            assert.equal(JSON.stringify(result), JSON.stringify(expectation));
        });
        it('should return datepicker days format for monday as first day', function() {
            var days = ['monday', 'tuesday', 'wednesday'];
            var result = convert.get_work_days(days, true);
            var expectation = [true, 1, 2, 3];
            assert.equal(JSON.stringify(result), JSON.stringify(expectation));
        });
    });
    describe('convertTimeToArray', function () {
        it('should return array from timeformat', function() {
            var result = convert.convertTimeToArray('12:35', false);
            var expectation = ['12', '35'];
            assert.equal(JSON.stringify(result), JSON.stringify(expectation));
        });
        it('should return array from timeformat', function() {
            var result = convert.convertTimeToArray('12', false);
            var expectation = ['12', 0];
            assert.equal(JSON.stringify(result), JSON.stringify(expectation));
        });
    });
});
