# Generic error handler

An easy to integrate error handler setup, made for PHP applications without one.

## What does it do?

It intercepts PHP errors, notices etc. and writes them into the PHP error log.

## Getting started

### Composer
```shell script
$ composer require sjoorm/generic-error-handler
```

```php
// TBD
```

### Direct installation

1. determine your include path by `php -i | grep include_path`
1. place [release](https://github.com/sjoorm/generic-error-handler/releases/latest) version in it
1. optional: edit `error_log` directive in your `php.ini` to write into the file instead of web server error log
1. add the following code to your entry point (e.g. Wordpress `wp-config.php`)
```php
require_once('generic-error-handler/init.php');
```

## Credits

Based on [Symfony/error-handler](http://github.com/symfony/error-handler) and [Seldaek/monolog](https://github.com/Seldaek/monolog).
