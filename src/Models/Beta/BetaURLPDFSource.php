<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaURLPDFSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $type, string $url)
    {
        $this->type = $type;
        $this->url = $url;
    }
}

BetaURLPDFSource::_loadMetadata();
