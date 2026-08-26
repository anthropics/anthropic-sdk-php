<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams\JWKS;

enum Type: string
{
    case DISCOVERY = 'discovery';

    case EXPLICIT_URL = 'explicit_url';

    case INLINE = 'inline';
}
