<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ToolChoiceAny implements BaseModel
{
    use Model;

    #[Api]
    public string $type;

    #[Api('disable_parallel_tool_use', optional: true)]
    public ?bool $disableParallelToolUse;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $type,
        ?bool $disableParallelToolUse = null
    ) {
        $this->type = $type;
        $this->disableParallelToolUse = $disableParallelToolUse;
    }
}

ToolChoiceAny::_loadMetadata();
