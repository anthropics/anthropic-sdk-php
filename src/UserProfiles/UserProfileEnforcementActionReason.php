<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

/**
 * Why Anthropic placed this enforcement action: `unsupported_region`, `fraud_or_abuse`, `high_harm`, `usage_policy_violation`, `account_compromise` or `unspecified`. More values may be added; read a value you do not recognize as `unspecified`.
 */
enum UserProfileEnforcementActionReason: string
{
    case UNSUPPORTED_REGION = 'unsupported_region';

    case FRAUD_OR_ABUSE = 'fraud_or_abuse';

    case HIGH_HARM = 'high_harm';

    case USAGE_POLICY_VIOLATION = 'usage_policy_violation';

    case ACCOUNT_COMPROMISE = 'account_compromise';

    case UNSPECIFIED = 'unspecified';
}
