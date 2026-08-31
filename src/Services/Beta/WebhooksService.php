<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\Webhooks\BetaWebhookEvent;
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
     * Parses a webhook payload into an event without verifying its signature. Prefer `unwrap()` unless
     * you have already verified the signature yourself.
     *
     * @throws WebhookException
     */
    public function parseUnverified(string $body): BetaWebhookEvent
    {
        try {
            $decoded = Util::decodeJson($body);

            // @phpstan-ignore return.type
            return Conversion::coerce(BetaWebhookEvent::class, value: $decoded);
        } catch (\Throwable $e) {
            throw new WebhookException('Error parsing webhook body', previous: $e);
        }
    }

    /**
     * @api
     *
     * Verifies the webhook signature from the `webhook-id`, `webhook-timestamp` and `webhook-signature`
     * headers using your webhook signing key, then parses the payload into an event. Fails if the
     * signature is missing or invalid.
     *
     * @param array<string,string|list<string>> $headers
     *
     * @throws WebhookException
     */
    public function unwrap(
        string $body,
        array $headers,
        ?string $secret = null
    ): BetaWebhookEvent {
        $secret = $secret ?? ($this->client->webhookKey ?: null);
        if (null === $secret || '' === $secret) {
            throw new WebhookException('Webhook key must not be null or empty in order to unwrap');
        }

        try {
            $flatHeaders = array_map(fn (string|array $v): string => is_array($v) ? $v[0] : $v, $headers);
            $webhook = new Webhook($secret);
            $webhook->verify($body, $flatHeaders);
        } catch (WebhookVerificationException $e) {
            throw new WebhookException('Could not verify webhook event signature', previous: $e);
        }

        try {
            $decoded = Util::decodeJson($body);

            // @phpstan-ignore return.type
            return Conversion::coerce(BetaWebhookEvent::class, value: $decoded);
        } catch (\Throwable $e) {
            throw new WebhookException('Error parsing webhook body', previous: $e);
        }
    }
}
