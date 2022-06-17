[![pipeline status](https://gitlab.com/wpdesk/wp-basic-requirements/badges/master/pipeline.svg)](https://gitlab.com/wpdesk/wp-basic-requirements/pipelines)
[![coverage report](https://gitlab.com/wpdesk/wp-basic-requirements/badges/master/coverage.svg?job=unit+test+lastest+coverage)](https://gitlab.com/wpdesk/wp-basic-requirements/commits/master)
[![Latest Stable Version](https://poser.pugx.org/wpdesk/wp-basic-requirements/v/stable)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![Total Downloads](https://poser.pugx.org/wpdesk/wp-basic-requirements/downloads)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![Latest Unstable Version](https://poser.pugx.org/wpdesk/wp-basic-requirements/v/unstable)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![License](https://poser.pugx.org/wpdesk/wp-basic-requirements/license)](https://packagist.org/packages/wpdesk/wp-basic-requirements)

# WP Basic Requirements

wp-basic-requirements is a simple library for WordPress plugins allowing to verify if the target environment meets the defined requirements. If not, it can be also used to display the notice to the users containing the proper information.

The library has to be compatible with PHP 5.2.x since it's the oldest acceptable version for WordPress to be run.

Available requirements to be defined:

- Minimal PHP version
- Minimal WordPress version
- Minimal WooCommerce version
- Required PHP module
- Required PHP setting
- OpenSSL version

## Requirements

PHP 5.2 or later.

## Installation via Composer

In order to install the bindings via [Composer](http://getcomposer.org/) run the following command:

```bash
composer require wpdesk/wp-basic-requirements
```

## Example usage

Use the following code in WordPress plugin's main .php file: 

```php
<?php

$requirements_checker = ( new WPDesk_Basic_Requirement_Checker_Factory )->create_from_requirement_array(
    __FILE__,
    'Example plugin name',
    [	
        'php'     => '7.0',
        'wp'      => '6.0',
        'plugins' => [
            [
                'name'      => 'woocommerce/woocommerce.php',
                'nice_name' => 'WooCommerce',
            ],
        ],
    ]
);

if ( $requirements_checker->are_requirements_met() ) {
    // plugin stuff goes here
} else {
    $requirements_checker->render_notices();
}
```
