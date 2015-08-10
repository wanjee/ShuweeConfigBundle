# Services

## Manager

Service id: `shuwee_config.manager`

Available methods:

### get

Returns the value for a single parameter.

```php
$configManager = $this->container->get('shuwee_config.manager');

return $configManager->get('machine_name', 'default value');
```

### all

Return an array of all parameters, indexed by their machine name.

```php
$configManager = $this->container->get('shuwee_config.manager');

return $configManager->all();
```
