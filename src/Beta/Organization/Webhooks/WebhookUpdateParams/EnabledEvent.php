<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks\WebhookUpdateParams;

enum EnabledEvent: string
{
    case EXTERNAL_KEY_FAILED = 'external_key.failed';

    case EXTERNAL_KEY_RECOVERED = 'external_key.recovered';

    case USER_PROFILE_ENFORCEMENT_ACTION_OPENED = 'user_profile.enforcement_action_opened';

    case USER_PROFILE_ENFORCEMENT_ACTION_RESOLVED = 'user_profile.enforcement_action_resolved';

    case USER_PROFILE_PROGRAM_STATUS_UPDATED = 'user_profile.program_status_updated';
}
