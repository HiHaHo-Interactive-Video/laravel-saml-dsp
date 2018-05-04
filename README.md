Laravel SAML - Dynamic SP
=========================

This Laravel package functions as a SAML Service Provider with the ability to connect to multiple Identity Providers.
It uses [onelogin/saml-php](https://github.com/onelogin/php-saml) to generate SAML responses and verify those responses from the IdPs.

This package was inspired by [aacotroneo/laravel-saml2](https://github.com/aacotroneo/laravel-saml2), but that package
only supports one IdP through the config file. This package uses the database to store the configuration of each IdP
and generates routes for each of these.

# :warning: Package in development :warning:

This package is not yet stable, you can test it by installing it, but the package may be subject to large changes before a final release

# Photoware

This package is free to use, but inspired by [Spaties' Poscardware](https://spatie.be/en/opensource/postcards) we'd love to see where 
where this package is being developed. A photo of an important landmark in your area would be highly appreciated.

Our email address is [photoware@hihaho.com](mailto:photoware@hihaho.com)

# Install

Simply add the following line to your ```composer.json``` and run ```composer update```
```
"hihaho/laravel-saml-dsp": "v0.1.*"
```
Or use composer to add it with the following command
```bash
composer require hihaho/laravel-saml-dsp
```

## Laravel Auto-Discovery

This package is automatically discovered with Laravel Auto-Discovery, if you wish to register the package yourself you
can add this package to your ```composer.json``` file:
```
"extra": {
    "laravel": {
        "dont-discover": [
            "hihaho/laravel-saml-dsp"
        ]
    }
}
``` 

# Usage
TODO

# TODO List
- [ ] Create / improve artisan commands
- [ ] Documentation
- [ ] Using custom Exceptions instead of \Exception
- [ ] UnitTests
- [ ] ...

# Contributors
- [Robert Boes](https://github.com/robertboes)
