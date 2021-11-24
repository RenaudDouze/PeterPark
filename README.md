# PeterPark

## To start

```bash
make install start tests
```

## Code quality

### PHP CS

PHPCS is based on default standard except InfinityloopCodingStandard which fix an issue with infinite loop

### PHPStan

Set on level 3 because of some properties which are never read. It's because it's just a test

## Tips

To use PHPCBF

```bash
docker-compose run --rm php ./vendor/bin/phpcbf --standard=vendor/infinityloop-dev/coding-standard/InfinityloopCodingStandard/ruleset.xml src/ tests/ features/bootstrap
```
