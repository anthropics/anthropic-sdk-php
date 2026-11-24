<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageFailedCheck;

/**
 * Which check failed, such as `label_mismatch` or `grant_mismatch`. Anthropic may add values.
 */
enum Check: string
{
    case BUCKET_SETTINGS = 'bucket_settings';

    case DELETION_POLICY = 'deletion_policy';

    case ENCRYPTION = 'encryption';

    case GRANT_MISMATCH = 'grant_mismatch';

    case KMS_KEY_REFUSED = 'kms_key_refused';

    case LABEL_MISMATCH = 'label_mismatch';

    case LIFECYCLE_RULES = 'lifecycle_rules';

    case LOCATION_MISMATCH = 'location_mismatch';

    case PROBE_FAILED = 'probe_failed';

    case PROJECT_NOT_VERIFIED = 'project_not_verified';

    case VERSIONING = 'versioning';
}
