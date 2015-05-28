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

## Bundle usage

TODO