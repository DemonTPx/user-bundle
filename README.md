# DemonTPx user bundle

This couples the FOSUserBundle to my Symfony apps

## Installation

Add the user bundle to your symfony project:

``` bash
$ compose require demontpx/user-bundle
```

## Configuration

User roles can be added in your `config/packages/demontpx_user.yaml`:

    demontpx_user:
        roles:
            ROLE_ADMIN: Administrator
            ROLE_GROUP_MANAGER: Group manager
            ROLE_SUPER: Super user

ORM Data fixtures for testing can be added in `config/packages/test/demontpx_user.yml`:

    demontpx_user:
        fixtures:
            user: ~
            admin: { roles: [ROLE_ADMIN] }
            super_user: { roles: [ROLE_ADMIN, ROLE_SUPER] }

Users will get the same password as the user name, and you will be able to use the `UserWebTestCase` class from the util bundle for your user-aware functional tests. You will also need to add this to your `config/packages/test/security.yml` to enable this:

    security:
        firewalls:
            main: # Replace this with your firewall name
                http_basic: ~

## Additional javascript and stylesheets

A SCSS file is located at `assets/user-bundle.scss` which could be imported.

Some elements have the `select2` class which could be enhanced by enabling [select2](https://select2.github.io/) on them.
