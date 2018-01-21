# Reservations plugin for OctoberCMS

[![Build Status](https://travis-ci.org/vojtasvoboda/oc-reservations-plugin.svg?branch=master)](https://travis-ci.org/vojtasvoboda/oc-reservations-plugin)
[![Codacy](https://img.shields.io/codacy/d46420185c9046db8208ab16d358a0d3.svg)](https://www.codacy.com/app/vojtasvoboda/oc-reservations-plugin)
[![Code Coverage](https://scrutinizer-ci.com/g/vojtasvoboda/oc-reservations-plugin/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/vojtasvoboda/oc-reservations-plugin/?branch=master)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/vojtasvoboda/oc-reservations-plugin/blob/master/LICENSE)

Provide reservation form with reservations management. You should also check related plugin: [backend calendar](http://octobercms.com/plugin/vojtasvoboda-reservationscalendar).

Key features:

- reservations have **coloured statuses**, **bulk actions** and **fulltext search** to save your time
- nice and clean **dashboard widget**
- reservations **export** with status filtering
- reservation can be created directly from the backend
- returning customers function

Technical features:

- shipped with **translations** and covered by **unit tests**
- reservation form has **CSRF protection** and **multiple bots submissions protection**
- reservation form has **AJAX sending** and also non-JS fallback
- overloadable **data seeding** for statuses

No other plugin dependencies. Tested with the latest stable OctoberCMS build 420 (with Laravel 5.5).

## Installation

1. Install plugin [VojtaSvoboda.Reservations](http://octobercms.com/plugin/vojtasvoboda-reservations)
2. Insert reservation form component to your page. Be sure you have jQuery loaded!

## Returning Customers

Plugin allow you to mark returning customers:

- set amount of previous reservations at **Backend > Settings > Reservations > Reservations** 
- at reservations listing, click at the list settings (the hamburger at the right corner) and check Returning
- it shows star at customers with more then <your-threshold> non-canceled reservations

## Admin confirmation

By default, plugin sends confirmation email to customer. But you can also turn on sending confirmation to different user 
(your customer, system administrator, etc). Follow these steps to turn this feature on:

- set admin email and name at **Backend > Settings > Reservations > Reservations** at **Admin confirmation** tab
- turn the admin confirmation by switch
- system will send special template 'reservation-admin', so feel free edit content of template at **Backend > Settings > Mail > Mail templates**

## Backend calendar

Looking for backend calendar to see your reservations visually? Take a look at [backend calendar](http://octobercms.com/plugin/vojtasvoboda-reservationscalendar) plugin.

## Public facade

You can use plugin's facade **vojtasvoboda.reservations.facade** with some public methods as follows:

```
$facade = App::make('vojtasvoboda.reservations.facade');
$facade->storeReservation(array $data);
$facade->getReservations();
$facede->getActiveReservations();
$facade->getReservedDates();
$facade->getReservationsByInterval(\Carbon\Carbon $from, \Carbon\Carbon $to);
$facade->isDateAvailable(\Carbon\Carbon $date);
```

## Configuration

You can find some plugin configuration at the CMS backend (datetime format, reservation length, time slot length, etc). 
But you can also set some values at plugin's config file. Config values are used when Settings value can not be found 
(and also because of backward compatibility with users using older version of plugin).

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

- [ ] Checkbox for disabling injecting assets to the components.
- [ ] Move date validation from facade to the model (it should works also when creating reservation from backend)
- [ ] Automatically load statuses for reservations listing/filtration.
- [ ] Assets concatenation.
- [ ] Log history of reservation changes.
- [ ] Make bulk reservation status change in one SQL query.
- [ ] Order by returning flag without SQL exception.
- [ ] Translate statuses at backend.
- [ ] Translations with Translate trait.
- [ ] Can send iCal link in the e-mail.
- [ ] Show only future dates in datepicker.
- [ ] Load only future reservations to the datepicker to show reserved slots.
- [ ] Reservations reminder by email/SMS, before reservation
- [ ] Own function (callback) for generating next reservation number.
- [ ] Sends confirmation email when admin [confirms the reservation](https://github.com/vojtasvoboda/oc-reservations-plugin/issues/2).

**Feel free to send pull request!**

## Contributing

Please send Pull Request to the master branch. Please add also unit tests and make sure all unit tests are green.

## License

Reservations plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as OctoberCMS platform.
