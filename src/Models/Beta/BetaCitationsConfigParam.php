<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaCitationsConfigParam implements BaseModel
{
    use Model;

    #[Api(optional: true)]
    public bool $enabled;

    /**
     * @param bool $enabled
     */
    final public function __construct(bool|None $enabled = None::NOT_SET)
    {

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

BetaCitationsConfigParam::_loadMetadata();
