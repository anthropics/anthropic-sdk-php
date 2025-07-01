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
    public string $ttl;

    /**
     * @param string $ttl
     */
    final public function __construct(
        string $type,
        None|string $ttl = None::NOT_SET
    ) {
        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);
    }
}

BetaCacheControlEphemeral::_loadMetadata();
