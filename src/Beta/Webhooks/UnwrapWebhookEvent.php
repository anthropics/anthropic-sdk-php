<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

// Loading the class registers this name as its alias.
class_exists(BetaWebhookEvent::class);

// This block never runs. It declares the name for IDEs and static analyzers.
// @phpstan-ignore if.alwaysFalse
if (false) {
    /**
     * @deprecated UnwrapWebhookEvent has been renamed to BetaWebhookEvent
     */
    class UnwrapWebhookEvent extends BetaWebhookEvent {}
}
