# PeterPark

## To start

```bash
make install start tests
```

## To run

```bash
make fleet list
```

Examples

```bash
make fleet create <userId>
make fleet register-vehicle <fleetId> <vehiclePlateNumber>
make fleet localize-vehicle <fleetId> <vehiclePlateNumber> lat lng [alt]
```


## Code quality

### PHP CS

PHPCS is based on default standard except InfinityloopCodingStandard which fix an issue with infinite loop

### PHPStan

Set on level 3 because of some properties which are never read. It's because it's just a test

## Tips

### Composer

```bash
docker run --rm --interactive --tty --volume $PWD:/app --user $USER_ID:$GROUP_ID composer require the-package-you-want-to-add
```

### PHPCBF

To use PHPCBF

```bash
docker-compose run --rm php ./vendor/bin/phpcbf --standard=vendor/infinityloop-dev/coding-standard/InfinityloopCodingStandard/ruleset.xml src/ tests/ features/bootstrap
```
