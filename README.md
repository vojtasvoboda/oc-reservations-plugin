# Reservations plugin for OctoberCMS

Provide quick reservation form.

- no plugin dependencies
- covered by unit tests

## Installation

1. Install plugin [VojtaSvoboda.Reservations](http://octobercms.com/plugin/vojtasvoboda-reservations)

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

- [ ] Make translations.
- [ ] When changing reservation from cancelled back, check date availability.
- [ ] Automatically load statuses for reservations listing/filtration.
- [ ] Log history of status changes.
- [ ] Make bulk reservation status change in one SQL request.

**Feel free to send pullrequest!**

## Contributing

Please send Pull Request to master branch.

## License

Reservations plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as OctoberCMS platform.
