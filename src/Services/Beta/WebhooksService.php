<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Webhooks\UnwrapWebhookEvent;
use Anthropic\Client;
use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\WebhookException;
use Anthropic\Core\Util;
use Anthropic\ServiceContracts\Beta\WebhooksContract;
use StandardWebhooks\Exception\WebhookVerificationException;
use StandardWebhooks\Webhook;

final class WebhooksService implements WebhooksContract
{
    /**
     * @api
     */
    public WebhooksRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WebhooksRawService($client);
    }

    /**
     * @api
     *
     * Unwraps a webhook event from its JSON representation.
     *
     * @param array<string,string|list<string>>|null $headers
     *
     * @throws WebhookException
     */
    public function unwrap(
        string $body,
        ?array $headers = null,
        ?string $secret = null
    ): UnwrapWebhookEvent {
        if (null !== $headers) {
            $secret = $secret ?? ($this->client->webhookKey ?: null);
            if (null === $secret) {
                throw new WebhookException('Webhook key must not be null in order to unwrap');
            }

            try {
                $flatHeaders = array_map(fn (string|array $v): string => is_array($v) ? $v[0] : $v, $headers);
                $webhook = new Webhook($secret);
                $webhook->verify($body, $flatHeaders);
            } catch (WebhookVerificationException $e) {
                throw new WebhookException('Could not verify webhook event signature', previous: $e);
            }
        }

        try {
            $decoded = Util::decodeJson($body);

            // @phpstan-ignore return.type
            return Conversion::coerce(UnwrapWebhookEvent::class, value: $decoded);
        } catch (\Throwable $e) {
            throw new WebhookException('Error parsing webhook body', previous: $e);
        }
    }
}
