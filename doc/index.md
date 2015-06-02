# Getting started


## Installation

Add ShuweeConfigBundle in your *composer.json*

``` .json
{
    "require": {
        "wanjee/shuwee-config-bundle": "dev-master"
    }
}
```

Ask composer to install the bundle and its dependencies

``` bash
composer update wanjee/shuwee-config-bundle
```

Register required bundles in *AppKernel.php* :

``` php
new Wanjee\Shuwee\ConfigBundle\ShuweeConfigBundle(),
```

Enable translation in your main config file

``` yaml
framework:
    translator:      { fallbacks: ["%locale%"] }
```

## Security 

2 roles are defined by ShuweeConfigBundle

* ROLE_PARAMETER_EDITOR
    + List parameters. 
    + Change parameters values. 
* ROLE_PARAMETER_ADMIN
    + Whatever ROLE_PARAMETER_EDITOR can do.
    + Create new parameters, choose their machine name and type.  
    + Can delete deprecated parameters.

In order to access admin pages for parameters you will need to configure your user roles accordingly

``` yaml
security:
    
    # ...
    
    role_hierarchy:
        ROLE_ADMIN:       [ROLE_USER, ROLE_PARAMETER_EDITOR]
        ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_PARAMETER_ADMIN, ROLE_ALLOWED_TO_SWITCH]
```
        
## Bundle usage

This modules relies on [ShuweeAdminBundle](https://github.com/wanjee/ShuweeAdminBundle) to administer parameters.
User with ROLE_PARAMETER_ADMIN (i.e. the dev or super admin) will have to define the required parameters and their type.
User with ROLE_PARAMETER_EDITOR (i.e. the webmaster) will have to choose values.

### Routing

Add ShuweeAdminBundle routing in *app/config/routing.yml*

``` yaml
shuwee_config:
    resource: "@ShuweeConfigBundle/Resources/config/routing.yml"
```
### API 

**/api/parameters** : Get the whole list of parameters
**/api/parameter/{machineName}** : Get a single parameter by its machine_name
 
 