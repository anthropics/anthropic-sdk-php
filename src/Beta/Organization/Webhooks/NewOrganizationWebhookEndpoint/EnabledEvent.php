<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks\NewOrganizationWebhookEndpoint;

enum EnabledEvent: string
{
    case USER_PROFILE_ENFORCEMENT_ACTION_OPENED = 'user_profile.enforcement_action_opened';

    case USER_PROFILE_ENFORCEMENT_ACTION_RESOLVED = 'user_profile.enforcement_action_resolved';
}
