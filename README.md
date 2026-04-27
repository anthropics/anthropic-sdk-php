# Claude SDK for PHP

[![Packagist Version](https://img.shields.io/packagist/v/anthropic-ai/sdk.svg)](https://packagist.org/packages/anthropic-ai/sdk)

The Claude SDK for PHP provides access to the [Claude API](https://docs.anthropic.com/en/api/) from PHP applications.

## Documentation

Full documentation is available at **[platform.claude.com/docs/en/api/sdks/php](https://platform.claude.com/docs/en/api/sdks/php)**.

## Installation

<!-- x-release-please-start-version -->

```sh
composer require "anthropic-ai/sdk:^0.17.1"
```

<!-- x-release-please-end -->

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

### Value Objects

It is recommended to use the static `with` constructor `Base64ImageSource::with(data: 'U3RhaW5sZXNzIHJvY2tz', ...)`
and named parameters to initialize value objects.

However, builders are also provided `(new Base64ImageSource)->withData('U3RhaW5sZXNzIHJvY2tz')`.

### Streaming

We provide support for streaming responses using Server-Sent Events (SSE).

```php
<?php

use Anthropic\Client;

$client = new Client(
  apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$stream = $client->messages->createStream(
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
  model: 'claude-sonnet-4-5-20250929',
);

foreach ($stream as $message) {
  var_dump($message);
}
```

### Structured Output

You can use PHP classes to define structured output schemas. The SDK will automatically convert your class to a JSON schema and parse responses back into typed objects.

```php
<?php

use Anthropic\Core\Helpers\StructuredOutputModel;

class Article extends StructuredOutputModel
{
    public string $title;
    public string $summary;
    /** @var string[] */
    public array $tags;
}

$message = $client->messages->create(
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Write an article about PHP']],
  model: 'claude-sonnet-4-5-20250929',
  outputConfig: ['format' => Article::class],
);

$article = $message->content[0]->parsed; // Article instance
echo $article->title;
```

See [examples/messages_structured_output.php](examples/messages_structured_output.php) for more examples including constraints, nested models, and streaming.

### Pagination

List methods in the Anthropic API are paginated.

This library provides auto-paginating iterators with each list response, so you do not have to request successive pages manually:

```php
<?php

use Anthropic\Client;

$client = new Client(
  apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$page = $client->beta->messages->batches->list(limit: 20);

var_dump($page);

// fetch items from the current page
foreach ($page->getItems() as $item) {
  var_dump($item->id);
}
// make additional network requests to fetch items from all pages, including and after the current page
foreach ($page->pagingEachItem() as $item) {
  var_dump($item->id);
}
```

### Handling errors

When the library is unable to connect to the API, or if the API returns a non-success status code (i.e., 4xx or 5xx response), a subclass of `Anthropic\Core\Exceptions\APIException` will be thrown:

```php
<?php

use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\RateLimitException;
use Anthropic\Core\Exceptions\APIStatusException;

try {
  $message = $client->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Hello, Claude']],
    model: 'claude-sonnet-4-5-20250929',
  );
} catch (APIConnectionException $e) {
  echo "The server could not be reached", PHP_EOL;
  var_dump($e->getPrevious());
} catch (RateLimitException $e) {
  echo "A 429 status code was received; we should back off a bit.", PHP_EOL;
} catch (APIStatusException $e) {
  echo "Another non-200-range status code was received", PHP_EOL;
  echo $e->getMessage();
}
```

Error codes are as follows:

| Cause            | Error Type                     |
| ---------------- | ------------------------------ |
| HTTP 400         | `BadRequestException`          |
| HTTP 401         | `AuthenticationException`      |
| HTTP 403         | `PermissionDeniedException`    |
| HTTP 404         | `NotFoundException`            |
| HTTP 409         | `ConflictException`            |
| HTTP 422         | `UnprocessableEntityException` |
| HTTP 429         | `RateLimitException`           |
| HTTP >= 500      | `InternalServerException`      |
| Other HTTP error | `APIStatusException`           |
| Timeout          | `APITimeoutException`          |
| Network error    | `APIConnectionException`       |

### Retries

Certain errors will be automatically retried 2 times by default, with a short exponential backoff.

Connection errors (for example, due to a network connectivity problem), 408 Request Timeout, 409 Conflict, 429 Rate Limit, >=500 Internal errors, and timeouts will all be retried by default.

You can use the `maxRetries` option to configure or disable this:

```php
<?php

use Anthropic\Client;

// Configure the default for all requests:
$client = new Client(requestOptions: ['maxRetries' => 0]);

// Or, configure per-request:
$result = $client->messages->create(
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
  model: 'claude-sonnet-4-5-20250929',
  requestOptions: ['maxRetries' => 5],
);
```

### File uploads

Request parameters that correspond to file uploads can be passed as a resource returned by `fopen()`, a string of file contents, or a `FileParam` instance.

```php
<?php

use Anthropic\Core\FileParam;

// Pass a string with filename and content type:
$contents = file_get_contents('/path/to/file');
// Pass a string with filename and content type:
$fileMetadata = $client->beta->files->upload(
  file: FileParam::fromString($contents, filename: '/path/to/file', contentType: '…'),
);

// Pass in only a string (where applicable)
$fileMetadata = $client->beta->files->upload(file: '…');

// Pass an open resource:
$fd = fopen('/path/to/file', 'r');
try {
  $fileMetadata = $client->beta->files->upload(
    file: FileParam::fromResource($fd, filename: '/path/to/file', contentType: '…'),
  );
} finally {
  fclose($fd);
}
```

## Advanced concepts

### Making custom or undocumented requests

#### Undocumented properties

You can send undocumented parameters to any endpoint, and read undocumented response properties, like so:

Note: the `extra*` parameters of the same name overrides the documented parameters.

```php
<?php

$message = $client->messages->create(
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
  model: 'claude-sonnet-4-5-20250929',
  requestOptions: [
    'extraQueryParams' => ['my_query_parameter' => 'value'],
    'extraBodyParams' => ['my_body_parameter' => 'value'],
    'extraHeaders' => ['my-header' => 'value'],
  ],
);
```

#### Undocumented request params

If you want to explicitly send an extra param, you can do so with the `extra_query`, `extra_body`, and `extra_headers` under the `request_options:` parameter when making a request, as seen in the examples above.

#### Undocumented endpoints

To make requests to undocumented endpoints while retaining the benefit of auth, retries, and so on, you can make requests using `client.request`, like so:

```php
<?php

$response = $client->request(
  method: "post",
  path: '/undocumented/endpoint',
  query: ['dog' => 'woof'],
  headers: ['useful-header' => 'interesting-value'],
  body: ['hello' => 'world']
);
```

## Versioning

This package follows [SemVer](https://semver.org/spec/v2.0.0.html) conventions. As the library is in initial development and has a major version of `0`, APIs may change at any time.

This package considers improvements to the (non-runtime) PHPDoc type definitions to be non-breaking changes.

## Requirements

PHP 8.1.0+

## Contributing

See [CONTRIBUTING.md](./CONTRIBUTING.md).

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
