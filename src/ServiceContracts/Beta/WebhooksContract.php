<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Webhooks\BetaWebhookEvent;
use Anthropic\Core\Exceptions\WebhookException;

interface WebhooksContract
{
    /**
     * @api
     *
     * Parses a webhook payload into an event without verifying its signature. Prefer `unwrap()` unless
     * you have already verified the signature yourself.
     *
     * @throws WebhookException
     */
    public function parseUnverified(string $body): BetaWebhookEvent;

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
    ): BetaWebhookEvent;
}
