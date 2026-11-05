# Anthropic SDK for PHP

[![Packagist Version](https://img.shields.io/packagist/v/anthropic-ai/sdk.svg)](https://packagist.org/packages/anthropic-ai/sdk)

The Anthropic SDK for PHP provides access to the [Claude API](https://docs.anthropic.com/en/api/) from PHP applications.

## Documentation

Full documentation is available at **[platform.claude.com/docs/en/api/sdks/php](https://platform.claude.com/docs/en/api/sdks/php)**.

## Installation

<!-- x-release-please-start-version -->

```sh
composer require "anthropic-ai/sdk:^1.6.0"
```

<!-- x-release-please-end -->

The SDK needs a [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP client. If you don't have one installed, add Guzzle:

```sh
composer require guzzlehttp/guzzle
```

## Getting started

```php
<?php

use Anthropic\Client;
use Anthropic\Messages\Model;

$client = new Client(
  apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$message = $client->messages->create(
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
  model: Model::CLAUDE_OPUS_5_5,
);

var_dump($message->content);
```

## Requirements

PHP 8.1.0+

## Autoloading note

This SDK includes class aliases for backwards compatibility, but these are not available when using authoritative classmaps in Composer.

If you use `composer --classmap-authoritative` and you rely on any of the following class names:

- `UnwrapWebhookEvent`

Then update your code to use the true class name.

## Contributing

See [CONTRIBUTING.md](./CONTRIBUTING.md).

## License

This project is licensed under the Apache License, Version 2.0. See the [LICENSE](LICENSE) file for details. Versions released before the change from the MIT License, and third-party contributions merged before it, remain under the MIT License. See [LICENSE-MIT](LICENSE-MIT).
