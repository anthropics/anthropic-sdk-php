<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Model\UnionMember0;

final class Completion implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'completion';

    #[Api]
    public string $id;

    #[Api]
    public string $completion;

    /** @var string|UnionMember0::* $model */
    #[Api]
    public string $model;

    #[Api('stop_reason')]
    public ?string $stopReason;

    /**
     * You must use named parameters to construct this object.
     *
     * @param string|UnionMember0::* $model
     */
    final public function __construct(
        string $id,
        string $completion,
        string $model,
        ?string $stopReason
    ) {
        $this->id = $id;
        $this->completion = $completion;
        $this->model = $model;
        $this->stopReason = $stopReason;

        self::_introspect();
    }
}
