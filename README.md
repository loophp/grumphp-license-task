[![Latest Stable Version][latest stable version]][1]
 [![GitHub stars][github stars]][1]
 [![Total Downloads][total downloads]][1]
 [![License][license]][1]

# GrumPHP License Task

## Description

This package provides a new [GrumPHP][5] task: `license`.

This task ensure that your project contains a valid license.

## Features

Checks if a `LICENSE.txt` already exists.

If it already exists, it compares it. If it doesn't match, [GrumPHP][5] will
propose to fix it for you.

If it doesn't exist, [GrumPHP][5] will create the file.

## Installation

```shell
composer require loophp/grumphp-license-task --dev
```

Then, edit your [GrumPHP][5] configuration file and register the extension:

```yaml
grumphp:
    extensions:
        - loophp\GrumphpLicenseTask\Extension
```

## Usage

A new task `license` will be available:

```yaml
taks:
    license:
        name: MIT
        date_from: 2021
        holder: Pol Dellaiera
```

### Available options

- `name`: (string) The OSI name of the license (see Available license).
- `input`: (string) The filepath to the file to use as license. Cannot be used
  in conjuction with `name`.
- `output`: (string) The output filename to use to save the license in.
- `date_from`: (int) The 'from' date in year.
- `holder`: (string) The holder's name.

### Available licenses

- BSD-3-Clause
- EUPL-1.2
- MIT
- LGPL-2.0
- LGPL-2.1
- LGPL-3.0
- ([submit an issue/pr][14] to add more)

## Contributing

Report bug on the [issue tracker][14].

See the file [CONTRIBUTING.md][18] but feel free to contribute to this library
by sending Github pull requests.

## Changelog

See [CHANGELOG.md][15] for a changelog based on [git commits][16].

For more detailed changelogs, please check [the release changelogs][17].

[latest stable version]: https://img.shields.io/packagist/v/loophp/grumphp-license-task.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/grumphp-license-task.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/grumphp-license-task.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/grumphp-license-task.svg?style=flat-square
[1]: https://packagist.org/packages/loophp/grumphp-license-task
[2]: https://github.com/loophp/grumphp-license-task/actions
[3]: https://scrutinizer-ci.com/g/loophp/grumphp-license-task/?branch=master
[4]: https://shepherd.dev/github/loophp/grumphp-license-task
[5]: https://packagist.org/packages/grumphp/grumphp
[6]: https://ec.europa.eu
[7]: https://packagist.org/packages/ergebnis/composer-normalize
[8]: https://packagist.org/packages/php-parallel-lint/php-parallel-lint
[9]: https://packagist.org/packages/friendsoftwig/twigcs
[10]: https://packagist.org/packages/FriendsOfPHP/PHP-CS-Fixer
[11]: https://www.php-fig.org/psr/psr-12/
[12]: https://packagist.org/packages/squizlabs/php_codesniffer
[13]: https://packagist.org/packages/phpstan/phpstan
[14]: https://github.com/loophp/grumphp-license-task/issues
[15]: https://github.com/loophp/grumphp-license-task/blob/master/CHANGELOG.md
[16]: https://github.com/loophp/grumphp-license-task/commits/master
[17]: https://github.com/loophp/grumphp-license-task/releases
[18]: https://github.com/loophp/grumphp-license-task/blob/master/.github/CONTRIBUTING.md
[19]: https://packagist.org/packages/drupol/php-conventions
[20]: https://packagist.org/packages/ergebnis/php-library-template
[21]: https://packagist.org/packages/ergebnis/license
[22]: https://packagist.org/packages/maglnet/composer-require-checker
