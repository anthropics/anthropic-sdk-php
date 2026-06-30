<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

enum BetaWebhookEnvironmentDeletedEventType: string
{
    case ENVIRONMENT_DELETED = 'environment.deleted';
}
