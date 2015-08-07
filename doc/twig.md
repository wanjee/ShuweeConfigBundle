# Twig

## Functions

### config_get_parameter()

`config_get_parameter` is a Twig function to retrieve the value of a parameter by its machine name.

#### Arguments

* *machine name*: machine name as you defined in the backend.
 
#### Returned value
 
Returned value depends on the parameter type you selected when creating the parameter.
 
##### Text

Most of the time it will be a simple text that you can output directly.

```
{{ config_get_parameter('machine_name') }}
{{ config_get_parameter('machine_name') | upper }}
```

Use Twig `default` filter to provide an alternative in case parameter is undefined or empty  

```
{{ config_get_parameter('machine_name') | default('Default value') | upper }}
``` 
    
##### Integer

See Text

##### Date 

Dates (date or datetime) cannot be output direclty.  Use Twig `date` filter to format it accordingly.

```
{{ config_get_parameter('date')|date('m/d/Y') }}
{{ config_get_parameter('datetime')|date('F jS \\a\\t g:ia') }}
```