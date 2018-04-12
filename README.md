# Taxman
![](https://img.shields.io/badge/size-50%20kB-brightgreen.svg)
[![Build Status](https://travis-ci.org/chriys/Taxman.svg?branch=master)](https://travis-ci.org/chriys/Taxman)
[![Maintainability](https://api.codeclimate.com/v1/badges/82f1863574f6c8753c85/maintainability)](https://codeclimate.com/github/chriys/Taxman/maintainability)


PHP Sales Tax calculator using custom or Canadian rates

## Requierements
This package requires `php 7.1`

## Installation
Install the packages via composer: `composer require chriys/taxman`.

## Getting started
This package allows to easily calculate taxes on an amount.
Currently two main ways are available: using rates of Canadian provinces or using custom rates.

### Using Canadian's provinces rates
```
    Taxes::calculate('10.00', 'alberta');
    // expected result
    [
        'sub_total' => '10.00',
        'taxes_details' => [
            'gst' => '0.5',
            'pst' => '0.8',
        ],
        'taxes' => '1.3',
        'total' => '11.3',
    ];
```

### Using custom taxes rates
```
    Taxes::calculate('45', [1, 2, 3]);
    // expected result
    [
        'sub_total' => '45',
        'taxes_details' => [
            0 => '0.45',
            1 => '0.9',
            2 => '1.35',
        ],
        'taxes' => '2.7',
        'total' => '47.7',
    ];
```


## Security
If you discover any security related issues, please contact the package developer at christian.ahidjo@gmail.com

## License
The Taxman package is open-sourced licensed under the [MIT License](License).