[![Build Status](https://travis-ci.org/mrtnzlml/hhvm-nette.svg?branch=master)](https://travis-ci.org/mrtnzlml/hhvm-nette)

Install dependencies:
```
composer install
bower install
```

Run HHVM in server mode (running Nginx is also needed):
```console
hhvm --mode server --config config.ini
```

Run tests:
```console
vendor/bin/run-tests -p hhvm -c config.ini tests/
```

Check code:
```console
hh_client .
```
