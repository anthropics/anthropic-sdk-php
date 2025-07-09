<?php

declare(strict_types=1);

namespace Anthropic\Models;

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

    /** @var string|string $model */
    #[Api]
    public mixed $model;

    #[Api('stop_reason')]
    public ?string $stopReason;

    #[Api]
    public string $type;

    /**
     * @param string        $id
     * @param string        $completion
     * @param string|string $model
     * @param null|string   $stopReason
     * @param string        $type
     */
    final public function __construct(
        $id,
        $completion,
        $model,
        $stopReason,
        $type
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

Completion::_loadMetadata();
