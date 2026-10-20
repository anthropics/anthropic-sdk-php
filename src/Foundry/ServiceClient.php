<?php

declare(strict_types=1);

namespace Anthropic\Foundry;

use Anthropic\RequestOptions;

/**
 * Runs the services of {@see Client} that take the first-party client: it sends their requests to the Foundry
 * client's base URL, with that client's headers, request options and credentials.
 *
 * @internal
 *
 * @phpstan-import-type OpenTelemetryOptions from \Anthropic\Core\BaseClient
 */
final class ServiceClient extends \Anthropic\Client
{
    /**
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param \Closure(): array<string,string> $authHeaders
     * @param OpenTelemetryOptions|null $openTelemetry
     */
    public function __construct(
        array $headers,
        string $baseUrl,
        RequestOptions $options,
        private \Closure $authHeaders,
        array|false|null $openTelemetry,
    ) {
        // Empty strings keep the first-party constructor from reading these values from the environment.
        parent::__construct(
            apiKey: '',
            webhookKey: '',
            baseUrl: $baseUrl,
            requestOptions: $options,
            openTelemetry: $openTelemetry,
        );

        // The first-party constructor may read `ANTHROPIC_AUTH_TOKEN`, which a Foundry client does not keep.
        $this->authToken = '';

        // The first-party constructor adds the headers of `ANTHROPIC_CUSTOM_HEADERS`, which a Foundry client does not send.
        $this->headers = $headers;
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return ($this->authHeaders)();
    }
}
