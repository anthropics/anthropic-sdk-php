<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class Completion implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public string $completion;

    /**
     * @var string|string $model
     */
    #[Api]
    public mixed $model;

    #[Api('stop_reason')]
    public ?string $stopReason;

    #[Api]
    public string $type;

    /**
     * @param string|string $model
     */
    final public function __construct(
        string $id,
        string $completion,
        mixed $model,
        ?string $stopReason,
        string $type,
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

Completion::_loadMetadata();
