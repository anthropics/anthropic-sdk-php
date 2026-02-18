# Claude SDK for PHP

[![Packagist Version](https://img.shields.io/packagist/v/anthropic-ai/sdk.svg)](https://packagist.org/packages/anthropic-ai/sdk)

The Claude SDK for PHP provides access to the [Claude API](https://docs.anthropic.com/en/api/) from PHP applications.

## Documentation

Full documentation is available at **[platform.claude.com/docs/en/api/sdks/php](https://platform.claude.com/docs/en/api/sdks/php)**.

## Installation

```sh
composer require "anthropic-ai/sdk"
```

## Getting started

```php
<?php

use Anthropic\Client;

$client = new Client(
  apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$message = $client->messages->create(
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
  model: 'claude-opus-4-6',
);

var_dump($message->content);
```

## Requirements

PHP 8.1.0+

## Contributing

See [CONTRIBUTING.md](./CONTRIBUTING.md).

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
