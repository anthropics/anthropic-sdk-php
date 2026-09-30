<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys\ExternalKeyUpdateParams\ProviderConfig;

enum Type: string
{
    case AWS = 'aws';

    case GCP = 'gcp';

    case AZURE = 'azure';
}
