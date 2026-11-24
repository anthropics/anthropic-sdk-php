<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageFailedCheck;

/**
 * Which check failed, such as `label_mismatch` or `grant_mismatch`. Anthropic may add values.
 */
enum Check: string
{
    case LABEL_MISMATCH = 'label_mismatch';

    case LOCATION_MISMATCH = 'location_mismatch';

    case ENCRYPTION = 'encryption';

    case VERSIONING = 'versioning';

    case BUCKET_SETTINGS = 'bucket_settings';

    case LIFECYCLE_RULES = 'lifecycle_rules';

    case DELETION_POLICY = 'deletion_policy';

    case GRANT_MISMATCH = 'grant_mismatch';

    case KMS_KEY_REFUSED = 'kms_key_refused';

    case PROBE_FAILED = 'probe_failed';

    case PROJECT_NOT_VERIFIED = 'project_not_verified';
}
