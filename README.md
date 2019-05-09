# Laravel 5.7 env() Polyfill

[![TravisCI](https://travis-ci.org/phpexpertsinc/Laravel57-env-polyfill.svg?branch=master)](https://travis-ci.org/phpexpertsinc/Laravel57-env-polyfill)
[![Test Coverage](https://api.codeclimate.com/v1/badges/4055759a290cbc797f5f/test_coverage)](https://codeclimate.com/github/phpexpertsinc/Laravel57-env-polyfill/test_coverage)

With the introduction of Laravel 5.8, they broke the essential `env()` function 
by changing it from reading from/writing to environment variables to only using 
the global `$_SERVER` array, which is totally useless in console-based apps.

See  
 * https://github.com/laravel/framework/pull/27462
 * https://github.com/laravel/framework/issues/27828
 * https://github.com/laravel/framework/issues/27949

Therefore, I took it upon myself to create this polyfill to ensure that the pre-5.8
behaviors remain intact.

Additionally, this is a great little utility function to use outside of Laravel-specic
projects that also want to use the `env()` function.

It is specially configured with a `0.0.1` composer vendor and a `AAutoloadFirst` 
namespace, so that composer will always load it before it gets to Laravel. 
See https://github.com/composer/composer/issues/6768

The source code is lifted directly from the last version of Laravel 5.7.

As you can imagine, most of the copyright in this project belongs to 
Taylor Otwell, 2018.

It also includes 100% unit test code .

## Installation

Via Composer

```bash
composer require 0.0.0/laravel-env-shim
```

## Usage

```php
putenv('foo=bar');
$foo = \env('foo'); // 'bar'
```

# Use cases

PHPExperts\Laravel57EnvPolyfill\Tests\Env  
 ✔ Env  
 ✔ Env with quotes  
 ✔ Env true  
 ✔ Env false  
 ✔ Env empty  
 ✔ Env null  
 ✔ Value  
 ✔ Env will use default value if needed

## Testing

```bash
phpunit
```

# Contributors

[Theodore R. Smith](https://www.phpexperts.pro/]) <theodore@phpexperts.pro>  
GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690  
CEO: PHP Experts, Inc.

[Taylor Otwell](https://www.laravel.com/)

## License

MIT license. Please see the [license file](LICENSE) for more information.
