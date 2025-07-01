<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Models\BetaErrorResponse;

class BetaMessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public BetaErrorResponse $error;

    #[Api]
    public string $type;

    final public function __construct(BetaErrorResponse $error, string $type)
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

BetaMessageBatchErroredResult::_loadMetadata();
