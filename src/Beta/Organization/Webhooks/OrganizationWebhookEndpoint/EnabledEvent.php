<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks\OrganizationWebhookEndpoint;

enum EnabledEvent: string
{
    case EXTERNAL_KEY_FAILED = 'external_key.failed';

    case EXTERNAL_KEY_RECOVERED = 'external_key.recovered';

    case EXTERNAL_STORAGE_FAILED = 'external_storage.failed';

    case EXTERNAL_STORAGE_RECOVERED = 'external_storage.recovered';

    case USER_PROFILE_ENFORCEMENT_ACTION_OPENED = 'user_profile.enforcement_action_opened';

    case USER_PROFILE_ENFORCEMENT_ACTION_RESOLVED = 'user_profile.enforcement_action_resolved';

    case USER_PROFILE_PROGRAM_STATUS_UPDATED = 'user_profile.program_status_updated';
}
