<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tracing;

use OpenTelemetry\API\Trace\SpanInterface;

/**
 * The call span that an SDK method started, with the name the method gave it. The method sets on `$span` what it
 * knows of its own request and response, and names both in the API call of the request options it passes to
 * `BaseClient::request()`, which sends the request under the span and ends it.
 *
 * @internal
 */
final class ApiCallSpan
{
    public function __construct(
        public readonly SpanInterface $span,
        public readonly string $name,
    ) {}
}
