<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCacheControlEphemeral\TTL;
use Anthropic\Models\Beta\BetaCacheControlEphemeral\Type;

final class BetaCacheControlEphemeral implements BaseModel
{
    use Model;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    /** @var null|TTL::* $ttl */
    #[Api(optional: true)]
    public ?string $ttl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::*     $type
     * @param null|TTL::* $ttl
     */
    final public function __construct(string $type, ?string $ttl = null)
    {
        $this->type = $type;
        $this->ttl = $ttl;
    }
}

BetaCacheControlEphemeral::_loadMetadata();
