<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaToolChoiceTool implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'tool';

    #[Api]
    public string $name;

    #[Api('disable_parallel_tool_use', optional: true)]
    public ?bool $disableParallelToolUse;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $name,
        ?bool $disableParallelToolUse = null
    ) {
        $this->name = $name;
        $this->disableParallelToolUse = $disableParallelToolUse;
    }
}

BetaToolChoiceTool::_loadMetadata();
