<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ToolChoiceTool\Type;

final class ToolChoiceTool implements BaseModel
{
    use Model;

    #[Api]
    public string $name;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api('disable_parallel_tool_use', optional: true)]
    public ?bool $disableParallelToolUse;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $name,
        string $type,
        ?bool $disableParallelToolUse = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->disableParallelToolUse = $disableParallelToolUse;
    }
}

ToolChoiceTool::_loadMetadata();
