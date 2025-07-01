<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Models\ErrorResponse;

class MessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public ErrorResponse $error;

    #[Api]
    public string $type;

    final public function __construct(ErrorResponse $error, string $type)
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

MessageBatchErroredResult::_loadMetadata();
