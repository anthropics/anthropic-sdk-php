<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActorProvider;

enum Type: string
{
    case AWS = 'aws';

    case AZURE = 'azure';

    case GCP = 'gcp';

    case OIDC = 'oidc';
}
