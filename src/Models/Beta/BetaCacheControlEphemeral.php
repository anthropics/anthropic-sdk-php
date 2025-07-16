<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCacheControlEphemeral\TTL;

final class BetaCacheControlEphemeral implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'ephemeral';

    /** @var null|TTL::* $ttl */
    #[Api(optional: true)]
    public ?string $ttl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|TTL::* $ttl
     */
    final public function __construct(?string $ttl = null)
    {
        $this->ttl = $ttl;
    }
}

BetaCacheControlEphemeral::_loadMetadata();
