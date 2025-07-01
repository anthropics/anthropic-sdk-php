<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class MessageBatchRequestCounts implements BaseModel
{
    use Model;

    #[Api]
    public int $canceled;

    #[Api]
    public int $errored;

    #[Api]
    public int $expired;

    #[Api]
    public int $processing;

    #[Api]
    public int $succeeded;

    final public function __construct(
        int $canceled,
        int $errored,
        int $expired,
        int $processing,
        int $succeeded
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

MessageBatchRequestCounts::_loadMetadata();
