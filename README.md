# Reservations plugin for OctoberCMS

Provide quick reservation form.

- no plugin dependencies
- covered by unit tests
- permission management for each functionality

## Installation

1. Install plugin [VojtaSvoboda.Reservations](http://octobercms.com/plugin/vojtasvoboda-reservations)
2. Insert reservation form to your page. Be sure you have jQuery loaded!

## Override configurations

...

## Override seeding

...

## Unit tests

Just run `phpunit` in plugin directory. For running plugin unit tests with other tests,
add this to your project phpunit.xml file:

```
<testsuites>
    <testsuite name="Reservation Tests">
        <directory>./plugins/vojtasvoboda/reservations/tests</directory>
    </testsuite>
</testsuites>
```

## Reservation Facade

Main facade provide this methods:

- storeReservation(array $data)
- getAllReservations()
- getReservedTimes()

## TODO

- [ ] Assets minification and concatenation!
- [ ] Load datetime format from config!
- [ ] Checkbox for disable injecting assets.
- [ ] Make translations.
- [ ] Add capacity parameter. Each time slot could have some capacity (number of tables, cars, etc.)
- [ ] When changing reservation from cancelled status back to available, check date availability.
- [ ] Create calendar report widget for showing taken dates.
- [ ] Create pie report widget for showing reservations by status.
- [ ] Automatically load statuses for reservations listing/filtration.
- [ ] Log history of status changes.
- [ ] Make bulk reservation status change in one SQL request.

**Feel free to send pullrequest!**

## Contributing

Please send Pull Request to master branch.

## License

Reservations plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as OctoberCMS platform.
