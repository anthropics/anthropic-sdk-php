<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Webhooks\UnwrapWebhookEvent;
use Anthropic\Core\Exceptions\WebhookException;

interface WebhooksContract
{
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
    ): UnwrapWebhookEvent;
}
