# Upgrade to 2.0

## DBAL 3

The most significant change in version 2.0 is using doctrine/dbal 3. You should [review their upgrade guide](https://github.com/doctrine/dbal/blob/bd54f5043eaff656b314037bf285d8b7f1c311b8/UPGRADE.md) in addition to this one.

## Lumen supported dropped
We recommend using eloquent instead.

## Minimum Doctrine/ORM version to 2.14

This release supports a minimum doctrine/orm version of 2.14 due to a number of deprecations and new features that we are taking advantage of.

## Proxy namespace required
You must now set a namespace for your proxies. Use the configuration option `proxies.namespace`. the previous default value was `DoctrineProxies`.

## Command signature changed

All doctrine commands are now extended from `doctrine` itself. Some of the command options have been changed or removed, and some have been added.

### Removed: FluentExporter, GenerateEntitiesCommand, GenerateRepositoriesCommand, ConvertMappingCommand, MappingImportCommand, ConvertConfigCommand

Doctrine is moving away from code generation and we are following suit, as well as reducing our maintenance burden.

## Removed MasterSlaveConnection

The old MasterSlaveConnection has been supported for backwards compatibility, but has now been removed. You can migrate to the new PrimaryReadReplicaConnection instead.

## Removed JSON type
If you were still including this line in your custom_types config, it should be removed:

``` 
'json' => LaravelDoctrine\ORM\Types\Json::class
```

## Short namespaces

Short namespaces such as `Entities:User` are no longer supported by Doctrine and have been removed.
