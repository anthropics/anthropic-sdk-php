# Claude SDK for PHP

[![Packagist Version](https://img.shields.io/packagist/v/anthropic-ai/sdk.svg)](https://packagist.org/packages/anthropic-ai/sdk)

The Claude SDK for PHP provides access to the [Claude API](https://docs.anthropic.com/en/api/) from PHP applications.

## Documentation

Full documentation is available at **[platform.claude.com/docs/en/api/sdks/php](https://platform.claude.com/docs/en/api/sdks/php)**.

## Installation

<!-- x-release-please-start-version -->

```sh
composer require "anthropic-ai/sdk:^1.3.0"
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

## OpenTelemetry

The SDK reports each API call as an OpenTelemetry span once your application has registered a tracer provider with the OpenTelemetry API (`open-telemetry/api`), which the SDK requires. Spans are on by default, so there is nothing to enable on the client.

The `openTelemetry` client option selects another tracer provider with `tracerProvider`, turns the trace context headers of the requests off with `propagation`, and configures the spans with `traces`:

- `enabled`: `false` turns the spans off. The other settings are then unused.
- `contentMode`: `'content'` adds the content of requests and responses to the spans. `'metadata_only'`, the default, leaves it out.
- `maxContentBytes`: the most bytes of content that one span holds, in place of the SDK's own bound of 0.75 MB. Content over the bound loses its oldest parts, and the span gets `anthropic.content.truncated`.

`'traces' => false` is short for `'traces' => ['enabled' => false]`, and `openTelemetry: false` is short for that. A key that the option does not take, such as a misspelt one, or a value it does not accept throws an `InvalidArgumentException`, as an unknown key or a `conversationId` that is no string does in the `openTelemetry` request option.

Each request carries the trace context of its span in the headers that your registered propagator writes. `'propagation' => false` leaves them out, for an application whose HTTP client instrumentation already propagates the trace context, so that a request does not carry it twice. A span that the sampler dropped is then still the current span while its requests are sent, so that the instrumentation continues the trace with that sampling decision. The spans are the same either way.

The environment variables `ANTHROPIC_OPEN_TELEMETRY`, `ANTHROPIC_OPEN_TELEMETRY_PROPAGATION`, `ANTHROPIC_OPEN_TELEMETRY_TRACES_CONTENT_MODE` and `ANTHROPIC_OPEN_TELEMETRY_TRACES_MAX_CONTENT_BYTES` set `traces.enabled`, `propagation`, `traces.contentMode` and `traces.maxContentBytes` for a client that is given no `openTelemetry` option. It reads them once, when it is built, so a later change to them does not reach it. A value they do not accept is ignored. A client that is given the option does not read them: what the option leaves unset has its default.

```php
<?php

use Anthropic\Client;

// a tracer provider other than the registered one
$client = new Client(openTelemetry: ['tracerProvider' => $tracerProvider]);

// no spans
$quiet = new Client(openTelemetry: false);

// spans, and no trace context headers on the requests
$unpropagated = new Client(openTelemetry: ['propagation' => false]);

// spans with the content of requests and responses, up to 64 KiB for each span
$verbose = new Client(openTelemetry: ['traces' => ['contentMode' => 'content', 'maxContentBytes' => 65536]]);

// sets gen_ai.conversation.id on the call's span; without it, only a call to a Session thread has one: the thread's ID
$client->messages->create(
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
  model: 'claude-sonnet-5',
  requestOptions: ['openTelemetry' => ['conversationId' => $conversationId]],
);
```

The `openTelemetry` request option of a call replaces the one in the client's `requestOptions` whole, as every request option does.

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
