<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks;

/**
 * Whether deliveries are sent to an organization webhook endpoint.
 */
enum OrganizationWebhookEndpointState: string
{
    case DISABLED = 'disabled';

    case ENABLED = 'enabled';
}
