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

## Plugin facade

You can use public facade `vojtasvoboda.reservations.facade` with some public methods:

```
$facade = App::make('vojtasvoboda.reservations.facade');
$facade->storeReservation(array $data);
$facade->getReservations();
$facade->getReservedDates();
$facade->isDateAvailable(Carbon $date);
```

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

## TODO

**Feel free to send pullrequest!**

- [ ] Make translations.
- [ ] Move date validation to Reservation model, because we need validation also when creating reservation from backend.
- [ ] Checkbox for disable injecting assets with components.
- [ ] Add capacity parameter. Each time slot could have some capacity (number of tables, cars, etc.)
- [ ] When changing reservation from cancelled status back to available, check date availability.
- [ ] Create calendar report widget for showing taken dates.
- [ ] Create pie report widget for showing reservations by status.
- [ ] Automatically load statuses for reservations listing/filtration.
- [ ] Assets concatenation.
- [ ] Log history of reservation changes.
- [ ] Make bulk reservation status change in one SQL request.

## Contributing

Please send Pull Request to master branch.

## License

Reservations plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as OctoberCMS platform.
