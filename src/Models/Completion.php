<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class Completion implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public string $completion;

    #[Api]
    public string $model;

    #[Api('stop_reason')]
    public ?string $stopReason;

    #[Api]
    public string $type = 'completion';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        string $completion,
        string $model,
        ?string $stopReason,
        string $type = 'completion',
    ) {
        $this->id = $id;
        $this->completion = $completion;
        $this->model = $model;
        $this->stopReason = $stopReason;
        $this->type = $type;
    }
}

Completion::_loadMetadata();
