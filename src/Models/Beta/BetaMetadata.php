<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaMetadata implements BaseModel
{
    use Model;

    #[Api('user_id', optional: true)]
    public ?string $userID;

    /**
     * @param null|string $userID
     */
    final public function __construct(null|None|string $userID = None::NOT_SET)
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

BetaMetadata::_loadMetadata();
