[![Build Status](https://travis-ci.org/mrtnzlml/hhvm-nette.svg?branch=master)](https://travis-ci.org/mrtnzlml/hhvm-nette)

Install dependencies:
```
composer install
bower install
```

Run HHVM in server mode:
```console
hhvm -m server -p 8080 -c config.ini
```

Run tests:
```console
vendor/bin/run-tests -p hhvm -c config.ini tests/
```
