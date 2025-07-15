<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCacheControlEphemeral implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    #[Api(optional: true)]
    public ?string $ttl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $type, ?string $ttl = null)
    {
        $this->type = $type;
        $this->ttl = $ttl;
    }
}

BetaCacheControlEphemeral::_loadMetadata();
