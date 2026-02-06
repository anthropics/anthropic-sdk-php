# Anthropic PHP API library

The Anthropic PHP library provides convenient access to the Anthropic REST API from any PHP 8.1.0+ application.

## Documentation

The REST API documentation can be found on [docs.anthropic.com](https://docs.anthropic.com/claude/reference/).

## Installation

<!-- x-release-please-start-version -->

```
composer require "anthropic-ai/sdk 0.5.0"
```

<!-- x-release-please-end -->

## Usage

This library uses named parameters to specify optional arguments.
Parameters with a default value must be set by name.

```php
<?php

use Anthropic\Client;

$client = new Client(
  apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$message = $client->messages->create(
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
  model: 'claude-sonnet-4-5-20250929',
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

## AWS Bedrock

This library also provides support for the [Anthropic Bedrock API](https://aws.amazon.com/bedrock/claude/) if you
install this library with the [`aws/aws-sdk-php`](https://packagist.org/packages/aws/aws-sdk-php) package.

### Installation

Install the AWS SDK for PHP alongside this package:

```
composer require aws/aws-sdk-php
```

### Usage

Create a Bedrock client and configure AWS credentials using the standard AWS SDK mechanisms
(environment variables, shared config files, or instance/role-based credentials):

```php
<?php

use Anthropic\Bedrock;

// Discover and create a Bedrock client from the current environment.
$client = Bedrock\Client::fromEnvironment();

// Or provide explicit credentials and region.
// $client = Bedrock\Client::withCredentials(
//   accessKeyId: 'YOUR_ACCESS_KEY_ID',
//   secretAccessKey: 'YOUR_AWS_SECRET',
//   region: 'us-east-1',
// );

$message = $client->messages->create(
  model: 'anthropic.claude-3-haiku-20240307-v1:0',
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
);

var_dump($message->content);
```

Note that Bedrock uses AWS-specific model identifiers or inference profile IDs, which differ from the
standard Anthropic API model IDs.

For AWS credential configuration details, see the AWS SDK for PHP documentation on the
[default credential provider chain](https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials_default_chain.html).

For more examples, see [`examples/bedrock`](examples/bedrock).

## Google Vertex

This library also provides support for the [Anthropic Vertex API](https://cloud.google.com/vertex-ai?hl=en) if you
install this library with the [`google/auth`](https://packagist.org/packages/google/auth) package.

### Installation

Install the Google Auth library alongside this package:

```
composer require google/auth
```

### Usage

Create a Vertex client with Application Default Credentials and your project/location:

```php
<?php

use Anthropic\Vertex;

$client = Vertex\Client::fromEnvironment(location: 'us-east5', projectId: 'my-project-id');

$message = $client->messages->create(
  model: 'claude-3-5-haiku@20241022',
  maxTokens: 1024,
  messages: [['role' => 'user', 'content' => 'Hello, Claude']],
);

var_dump($message->content);
```

If you omit `projectId`, the client will try to resolve it from standard Google Cloud environment
variables or your credentials.

Note that Vertex uses Vertex-specific model identifiers or inference profile IDs, which differ from the
standard Anthropic API model IDs.

For setting up Application Default Credentials, see
[Set up ADC for a local development environment](https://cloud.google.com/docs/authentication/set-up-adc-local-dev-environment).

For more examples, see [`examples/vertex`](examples/vertex).

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

PHP 8.1.0 or higher.

## Contributing

See [the contributing documentation](https://github.com/anthropics/anthropic-sdk-php/tree/main/CONTRIBUTING.md).
