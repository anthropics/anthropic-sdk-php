<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

// @deprecated UnwrapWebhookEvent has been renamed to BetaWebhookEvent
class_alias(
    BetaWebhookEvent::class,
    'Anthropic\Beta\Webhooks\UnwrapWebhookEvent'
);
