<?php

declare(strict_types=1);

namespace Anthropic\Organization\Federation\Issuers\IssuerCreateParams\JWKS;

enum Type: string
{
    case DISCOVERY = 'discovery';

    case EXPLICIT_URL = 'explicit_url';

    case INLINE = 'inline';
}
