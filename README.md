# Reservations plugin for OctoberCMS

Provide reservation form with reservations management.

Key features:

- reservations have **coloured statuses**, **bulk actions** and **fulltext search** to save your time
- nice and clean **dashboard widget**
- reservations **exporting** also with status filtering
- reservation can be created directly from the backend

Technical features:

- shipped with **translations** and covered by **unit tests**
- reservation form has **CSRF protection** and **multiple bots submissions protection**
- reservation form has **AJAX sending** and also non-JS fallback
- overloadable **data seeding** for statuses

No other plugin dependencies.

## Installation

1. Install plugin [VojtaSvoboda.Reservations](http://octobercms.com/plugin/vojtasvoboda-reservations)
2. Insert reservation form component to your page. Be sure you have jQuery loaded!

## Public facade

You can use plugin's facade **vojtasvoboda.reservations.facade** with some public methods as follows:

```
$facade = App::make('vojtasvoboda.reservations.facade');
$facade->storeReservation(array $data);
$facade->getReservations();
$facede->getActiveReservations();
$facade->getReservedDates();
$facade->isDateAvailable(\Carbon\Carbon $date);
```

## Override configurations

When you want to override default plugin's *config.php*, which is placed at plugin's folder */config*, just create file:

`/config/vojtasvoboda/reservations/config.php`

And override values you want to change. Example of this file:

```
<?php return [
    'formats' => [
        'date' => 'd.m.Y H:i:s',
    ],
];
```

## Override seeding

For override seeding just copy seed files from plugin's folder */updates/sources* and copy them to:
 
`/resources/vojtasvoboda/reservations/updates/sources/`

For example:

`/resources/vojtasvoboda/reservations/updates/sources/statuses.yaml`

This file will be load with first migration, or you can force refreshing migrations with this command:

`php artisan plugin:refresh VojtaSvoboda.Reservations`

## Unit tests

Just run `phpunit` in the plugin directory. For running plugin's unit tests with project tests,
add this to your project *phpunit.xml* file:

```
<testsuites>
    <testsuite name="Reservation Tests">
        <directory>./plugins/vojtasvoboda/reservations/tests</directory>
    </testsuite>
</testsuites>
```

Receiving "Class 'PluginTestCase' not found" error? Just type `composer dumpautoload` at your project root.

## TODO

**Feel free to send pull request!**

- [ ] Complate all translations.
- [ ] Put some config to backend Settings (mail BCC, etc).
- [ ] Move date validation to Reservation model, because we need validation also when creating new reservation from the backend.
- [ ] When changing reservation from cancelled status back to available, check date availability.
- [ ] Checkbox for disabling injecting assets with components.
- [ ] Add capacity parameter. Each time slot should have some capacity (number of tables, cars, seets etc.)
- [ ] Create calendar report widget for showing taken dates.
- [ ] Create pie report widget for showing reservations by status.
- [ ] Automatically load statuses for reservations listing/filtration.
- [ ] Assets concatenation.
- [ ] Log history of reservation changes.
- [ ] Make bulk reservation status change in one SQL query.

## Contributing

Please send Pull Request to the master branch. Please add also unit tests and make sure all unit tests are green.

## License

Reservations plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as OctoberCMS platform.
