# DemonTPx user bundle

This couples the FOSUserBundle to my Symfony2 apps

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
        new DemonTPx\UserBundle\DemonTPxUserBundle(),
    );
}
```
