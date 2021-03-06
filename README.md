[![Build Status](https://travis-ci.org/enniel/ami.svg?branch=master)](https://travis-ci.org/enniel/ami)
[![StyleCI](https://styleci.io/repos/62553643/shield?branch=master)](https://styleci.io/repos/62553643)
# Jialbanc\Ami

Easy control via [asterisk](http://www.asterisk.org/) manager interface (AMI).

This is an update from original project [enniel/ami](https://github.com/enniel/ami/)

Installation and configuration
----------------

To install as a [composer](https://getcomposer.org/) package to be used with Laravel 5, simply run:

```sh
composer require "jialbanc/ami"
```

Then publish assets with `php artisan vendor:publish`. This will add the file `config/ami.php`.

Usage
----------------
**Connection options**

You are can specify connection parameters for each command.

| Option     | Description                  |
| ---------  | ---------------------------- |
| --host     | Asterisk AMI server host     |
| --port     | Asterisk AMI server port     |
| --username | Asterisk AMI server username |
| --secret   | Asterisk AMI server secret   |

**Listen ami events**

```sh
php artisan ami:listen
```

```php
Artisan::call('ami:listen');
```
If would you like to see event log in the console use *monitor* option
```sh
php artisan ami:listen --monitor
```

**Send ami action**

```sh
php artisan ami:action <action> --arguments=<key>:<value> --arguments=<key>:<value> ...
```

```php
Artisan::call('ami:action', [
    'action'      => <action>,
    '--arguments' => [
        <key> => <value>
        ...
    ]
]);
```

**Send sms messages using chan dongle**

```sh
php artisan ami:dongle:sms <phone> <message> <device?>
```

```php
Artisan::call('ami:dongle:sms', [
    'phone'   => <phone>,
    'message' => <message>,
    'device'  => <device?>,
]);
```

**Send ussd commands using chan dongle**

```sh
php artisan ami:dongle:ussd <device> <ussd>
```

```php
Artisan::call('ami:dongle:ussd', [
    'device' => <device>,
    'ussd'   => <ussd>,
]);
```
**Send ami commands**

This command started cli interface for ami. Command attribute is optional.
```sh
php artisan ami:cli [command]
```
Close cli interface after sending command.
```sh
php artisan ami:cli [command] --autoclose
```

```php
Artisan::call('ami:cli', [
    'command'     => [command],
    '--autoclose' => true,
]);
```