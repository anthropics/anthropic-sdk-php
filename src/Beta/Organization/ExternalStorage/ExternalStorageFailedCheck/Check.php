<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage\ExternalStorageFailedCheck;

/**
 * Name of the check that failed, such as `versioning`, for code to branch on. New names may be added; `other` is a check this API does not name. The value is a name with no data of its own.
 */
enum Check: string
{
    case ALREADY_REGISTERED = 'already_registered';

    case ASSUME_ROLE = 'assume_role';

    case BUCKET_EMPTY = 'bucket_empty';

    case BUCKET_NOT_CONFIRMED = 'bucket_not_confirmed';

    case BUCKET_POLICY = 'bucket_policy';

    case BUCKET_SETTINGS = 'bucket_settings';

    case DEFAULT_ENCRYPTION = 'default_encryption';

    case DELETION_POLICY = 'deletion_policy';

    case ENCRYPTION = 'encryption';

    case GRANT_MISMATCH = 'grant_mismatch';

    case KEY_USABLE = 'key_usable';

    case KMS_KEY_REFUSED = 'kms_key_refused';

    case LIFECYCLE_NO_ARCHIVE = 'lifecycle_no_archive';

    case LIFECYCLE_RULES = 'lifecycle_rules';

    case LIFECYCLE_TEMPLATE = 'lifecycle_template';

    case LOCATION_MISMATCH = 'location_mismatch';

    case OBJECT_LOCK = 'object_lock';

    case OTHER = 'other';

    case OWNERSHIP_ENFORCED = 'ownership_enforced';

    case PROBE_FAILED = 'probe_failed';

    case PROBE_OBJECT = 'probe_object';

    case PROBE_STORAGE_CLASS = 'probe_storage_class';

    case PUBLIC_ACCESS_BLOCK = 'public_access_block';

    case REGION = 'region';

    case REPLICATION = 'replication';

    case REQUEST_METRICS = 'request_metrics';

    case REQUEST_PAYMENT = 'request_payment';

    case TRANSCRIPTS_SUPPORT = 'transcripts_support';

    case TRUST_INGEST_ROLE = 'trust_ingest_role';

    case TRUST_MAINTENANCE_ROLE = 'trust_maintenance_role';

    case TRUST_MEDIA_ERASURE_ROLE = 'trust_media_erasure_role';

    case TRUST_READ_ROLE = 'trust_read_role';

    case TRUST_TRANSCRIPTS_ROLE = 'trust_transcripts_role';

    case TRUST_TRANSCRIPTS_VERIFY_ROLE = 'trust_transcripts_verify_role';

    case TRUST_VERIFY_ROLE = 'trust_verify_role';

    case VERSIONING = 'versioning';
}
