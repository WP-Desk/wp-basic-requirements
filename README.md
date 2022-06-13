[![pipeline status](https://gitlab.com/wpdesk/wp-basic-requirements/badges/master/pipeline.svg)](https://gitlab.com/wpdesk/wp-basic-requirements/pipelines)
[![coverage report](https://gitlab.com/wpdesk/wp-basic-requirements/badges/master/coverage.svg?job=unit+test+lastest+coverage)](https://gitlab.com/wpdesk/wp-basic-requirements/commits/master)
[![Latest Stable Version](https://poser.pugx.org/wpdesk/wp-basic-requirements/v/stable)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![Total Downloads](https://poser.pugx.org/wpdesk/wp-basic-requirements/downloads)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![Latest Unstable Version](https://poser.pugx.org/wpdesk/wp-basic-requirements/v/unstable)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![License](https://poser.pugx.org/wpdesk/wp-basic-requirements/license)](https://packagist.org/packages/wpdesk/wp-basic-requirements)

WP Basic Requirements
=====================

Wp-basic-requirements is a simple library for WordPress plugins to check if the environment meets the requirements
and if the requirements are not met shows proper notice to user.

Library have to be compatible with PHP 5.2.x as it's the lowest possible version for WordPress.

Requirements may be:
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

Use this code in main WordPress plugin file: 

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
