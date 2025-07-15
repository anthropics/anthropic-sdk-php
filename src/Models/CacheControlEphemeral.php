<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class CacheControlEphemeral implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $type)
    {
        $this->type = $type;
    }
}

CacheControlEphemeral::_loadMetadata();
