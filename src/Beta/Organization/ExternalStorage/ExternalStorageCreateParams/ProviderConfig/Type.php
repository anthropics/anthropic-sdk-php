<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams\ProviderConfig;

enum Type: string
{
    case AWS = 'aws';

    case GCP = 'gcp';
}
