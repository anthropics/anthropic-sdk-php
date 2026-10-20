<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams;

/**
 * `disabled` stops deliveries. `enabled` resumes them and clears `disabled_reason`. Events that happen while the endpoint is disabled are never delivered.
 */
enum State: string
{
    case DISABLED = 'disabled';

    case ENABLED = 'enabled';
}
