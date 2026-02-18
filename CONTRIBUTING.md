## Contributing to documentation

The documentation for this SDK lives at [platform.claude.com/docs/en/api/sdks/php](https://platform.claude.com/docs/en/api/sdks/php). To suggest changes, open an issue.

## Setting up the environment

This repository uses [Composer](https://getcomposer.org/) for dependency management.

To set up the repository, run:

```sh
$ composer install
```

Or use the bootstrap script:

```sh
$ ./scripts/bootstrap
```

## Modifying/Adding code

Most of the SDK is generated code. Modifications to code will be persisted between generations, but may
result in merge conflicts between manual patches and changes from the generator. The generator will never
modify the contents of the `examples/` directory.

## Adding and running examples

All files in the `examples/` directory are not modified by the generator and can be freely edited or added to.

## Running tests

Most tests require you to [set up a mock server](https://github.com/stoplightio/prism) against the OpenAPI spec to run the tests.

```sh
$ npx prism mock path/to/your/openapi.yml
```

```sh
$ ./scripts/test
```

## Linting and formatting

This repository uses [PHPStan](https://phpstan.org/) for static analysis and [PHP CS Fixer](https://cs.symfony.com/) for formatting.

To lint:

```sh
$ ./scripts/lint
```

To format:

```sh
$ ./scripts/format
```

## Publishing and releases

Changes made to this repository via the automated release PR pipeline should publish to Packagist automatically. If
the changes aren't made through the automated pipeline, you may want to make releases manually.
