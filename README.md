
# Laravel Development Package Tools

Laravel Development Package Tools

## Installation

You can install the package via composer:

```bash
composer require deka/laravel-package-tools
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-package-tools-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-package-tools-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-package-tools-views"
```

## Usage

```php
$laravelPackageTools = new Deka\LaravelPackageTools();
echo $laravelPackageTools->echoPhrase('Hello, Deka!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rizky Hajar](https://github.com/riskihajar)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
