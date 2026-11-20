<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage\ExternalStorageFailedCheck;

/**
 * The part of your access grant that the check is about, such as `ingest`: on AWS, one of the IAM roles your setup created; on Google Cloud, the grant to one of Anthropic's service accounts. `null` when the check is not about one. New names may be added. The value is a name with no data of its own.
 */
enum Role: string
{
    case INGEST = 'ingest';

    case MAINTENANCE = 'maintenance';

    case MEDIA_ERASURE = 'media_erasure';

    case READ = 'read';

    case TRANSCRIPTS = 'transcripts';

    case TRANSCRIPTS_VERIFY = 'transcripts_verify';

    case VERIFY = 'verify';
}
