<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaCacheControlEphemeral implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    #[Api(optional: true)]
    public ?string $ttl;

    /**
     * @param string      $type
     * @param null|string $ttl
     */
    final public function __construct($type, $ttl = None::NOT_GIVEN)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCacheControlEphemeral::_loadMetadata();
