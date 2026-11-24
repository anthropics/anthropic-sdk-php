<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageFailedCheck;

/**
 * On a check about one of the accounts that Anthropic uses to reach the bucket, that account's kind of access, such as `ingest`. `null` on any other check. Anthropic may add values.
 */
enum Role: string
{
    case INGEST = 'ingest';

    case READ = 'read';

    case MAINTENANCE = 'maintenance';

    case MEDIA_ERASURE = 'media_erasure';

    case VERIFY = 'verify';
}
