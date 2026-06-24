[![pipeline status](https://gitlab.com/wpdesk/wp-basic-requirements/badges/master/pipeline.svg)](https://gitlab.com/wpdesk/wp-basic-requirements/pipelines)
[![coverage report](https://gitlab.com/wpdesk/wp-basic-requirements/badges/master/coverage.svg?job=unit+test+lastest+coverage)](https://gitlab.com/wpdesk/wp-basic-requirements/commits/master)
[![Latest Stable Version](https://poser.pugx.org/wpdesk/wp-basic-requirements/v/stable)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![Total Downloads](https://poser.pugx.org/wpdesk/wp-basic-requirements/downloads)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![Latest Unstable Version](https://poser.pugx.org/wpdesk/wp-basic-requirements/v/unstable)](https://packagist.org/packages/wpdesk/wp-basic-requirements)
[![License](https://poser.pugx.org/wpdesk/wp-basic-requirements/license)](https://packagist.org/packages/wpdesk/wp-basic-requirements)

# WP Basic Requirements

`wp-basic-requirements` is a small library for WordPress plugins that checks whether the environment meets defined requirements and can display an admin notice when it does not.

It supports checks for:

- minimum PHP version
- minimum WordPress version
- required plugins
- required repository plugins
- required classes
- required PHP modules

## Requirements

PHP 5.3 or later.

## Installation via Composer

In order to install the bindings via [Composer](http://getcomposer.org/) run the following command:

```bash
composer require wpdesk/wp-basic-requirements
```

## Example usage

Use the following code in the main plugin file:

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
                'version'   => '8.0',
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
