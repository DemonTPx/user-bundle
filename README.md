# DemonTPx user bundle

This couples the FOSUserBundle to my Symfony apps

## Installation

Add the user bundle to your `composer.json`:

``` js
{
    "require": {
        "demontpx/user-bundle": "dev-master"
    }
}
```

Then tell composer to download the bundle:

``` bash
$ composer update demontpx/user-bundle
```

Enable the bundle in your kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Demontpx\UserBundle\DemontpxUserBundle(),
    );
}
```

## Configuration

User roles can be added in your `app/config/config.yml`:

    demontpx_user:
        roles:
            ROLE_ADMIN: Administrator
            ROLE_GROUP_MANAGER: Group manager
            ROLE_SUPER: Super user

ORM Data fixtures can also be created in `app/config/config.yml` (or `config_test.yml` if you prefer):

    demontpx_user:
        fixtures:
            user: ~
            admin: { roles: [ROLE_ADMIN] }
            super_user: { roles: [ROLE_ADMIN, ROLE_SUPER] }

Users will get the same password as the user name, and you will be able to use the `UserWebTestCase` class from the util bundle for your user-aware functional tests. You will also need to add this to your `config_test.yml` to enable this:

    security:
        firewalls:
            main: # Replace this with your firewall name
                http_basic: ~
